<?php

declare(strict_types=1);

namespace Application\Listeners;

use Core\Entity\History;
use Core\Interfaces\HistorizableInterface;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\MappingException;
use Exception;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class HistoryListener
 * @package Application\Listeners
 */
class HistoryListener implements EventSubscriber
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    protected $histories = [];
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var array
     */
    private $events;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        array $events = [Events::postPersist, Events::postUpdate, Events::postRemove]
    ) {
        $this->entityManager = $entityManager;
        $this->logger        = $logger;
        $this->events        = $events;
    }

    /**
     * @param        $entity
     * @param string $action
     *
     * @throws ReflectionException
     */
    public function createHistory($entity, string $action)
    {
        $changeSet   = $this->entityManager->getUnitOfWork()->getEntityChangeSet($entity);
        $entityClass = $entity->getHistoryClass();
        $performedAt = new DateTime();

        foreach ($changeSet as $propertyName => $values) {
            $oldValue = $action === History::TYPE_INSERT ? null : $this->convertValue($values[0]);
            $newValue = $action === History::TYPE_DELETE ? null : $this->convertValue($values[1]);

            $history = ((new ReflectionClass($entityClass))->newInstance())
                ->setType($action)
                ->setOwner($entity)
                ->setPropertyName($propertyName)
                ->setOldValue($oldValue)
                ->setNewValue($newValue)
                ->setPerformedAt($performedAt);

            $this->histories[] = $history;
        }
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return array_merge($this->events, [Events::postFlush]);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @throws ReflectionException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$this->checkValidity($args->getObject())) {
            return;
        }

        $this->createHistory($args->getObject(), History::TYPE_INSERT);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @throws ReflectionException
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        if (!$this->checkValidity($args->getObject())) {
            return;
        }

        $this->createHistory($args->getObject(), History::TYPE_UPDATE);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @throws ReflectionException
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        if (!$this->checkValidity($args->getObject())) {
            return;
        }

        $this->createHistory($args->getObject(), History::TYPE_DELETE);
    }

    public function postFlush()
    {
        if (empty($this->histories)) {
            return;
        }

        foreach ($this->histories as $i => $history) {
            $this->entityManager->persist($history);
        }

        $this->histories = [];
        $this->entityManager->flush();
    }

    /**
     * Converts a value to be stored in the history.
     *
     * @param mixed $value
     *
     * @return string|null
     */
    protected function convertValue($value)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_object($value)) {
            try {
                return $this->getObjectIdentifier($value);
            } catch (Exception $exception) {
                return (string) $value;
            }
        }

        return (string) $value;
    }

    /**
     * @param $object
     *
     * @return string
     * @throws MappingException
     */
    protected function getObjectIdentifier($object): string
    {
        $metadata         = $this->entityManager->getClassMetadata(get_class($object));
        $propertyAccessor = new PropertyAccessor();

        return (string) $propertyAccessor->getValue($object, $metadata->getSingleIdentifierFieldName());
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    protected function checkValidity($entity): bool
    {
        if ($entity instanceof HistorizableInterface) {
            return true;
        }

        return false;
    }
}
