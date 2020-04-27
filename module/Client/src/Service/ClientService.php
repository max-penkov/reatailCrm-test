<?php

declare(strict_types=1);

namespace Client\Service;

use Client\Repository\ClientRepositoryInterface;
use Ds\Map;

/**
 * Class ClientService
 * @package Client\Service
 */
class ClientService
{
    /**
     * @var ClientRepositoryInterface
     */
    private $repository;

    /**
     * ClientService constructor.
     *
     * @param ClientRepositoryInterface $repository
     */
    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return Map
     */
    public function fetchAll(int $page, int $limit)
    {
        $total = $this->repository->getTotal();

        $offset = $limit * ($page - 1);

        $collection = $this->repository->fetchAll($limit, $offset);

        return new Map(['total' => $total, 'collection' => $collection]);
    }

}