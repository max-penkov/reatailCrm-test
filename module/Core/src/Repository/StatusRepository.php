<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Entity\Status;
use Doctrine\ORM\EntityRepository;

/**
 * Class StatusRepository
 * @package Core\Repository
 */
class StatusRepository extends EntityRepository
{
    /**
     * @param string $code
     *
     * @return Status|object|null
     */
    public function getByStatusCode(string $code): ?Status
    {
        return $this->findOneBy(['code' => $code]);
    }
}
