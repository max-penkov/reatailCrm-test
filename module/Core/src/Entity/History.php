<?php

declare(strict_types=1);

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class History
 * @package Core\Entity
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_class", type="string")
 * )
 */
abstract class History
{
    const TYPE_INSERT = 'insert';
    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';

    /**
     * @ORM\Column(type="guid", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $propertyName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $oldValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $newValue;

    /**
     * @ORM\Column(type="string", length=6)
     */
    protected $type;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $performedAt;

    /**
     * @return mixed
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param $propertyName
     *
     * @return $this
     */
    public function setPropertyName($propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @param $oldValue
     *
     * @return $this
     */
    public function setOldValue($oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @param $newValue
     *
     * @return $this
     */
    public function setNewValue($newValue): self
    {
        $this->newValue = $newValue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPerformedAt()
    {
        return $this->performedAt;
    }

    /**
     * @param $performedAt
     *
     * @return $this
     */
    public function setPerformedAt($performedAt): self
    {
        $this->performedAt = $performedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
