<?php

declare(strict_types=1);

namespace Client\Service;

use Client\Entity\Client;
use Client\Repository\ClientRepositoryInterface;
use DomainException;
use Ds\Map;
use Exception;

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

    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @return Client
     */
    public function create(string $name, string $email, string $phone)
    {
        try {
            $client = new Client($name, $email, $phone);
            $client = $this->repository->save($client);
        } catch (Exception $e) {
            throw new DomainException(
                sprintf('Cant\'t create new client: %s', $e->getMessage()),
                0,
                $e
            );
        }

        return $client;
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @return Client
     */
    public function update(string $id, string $name, string $email, string $phone)
    {
        try {
            $client = $this->repository->get($id);
            $client->edit($name, $email, $phone);
            $client = $this->repository->save($client);
        } catch (Exception $e) {
            throw new DomainException(
                sprintf('Cant\'t updated client: %s', $e->getMessage()),
                0,
                $e
            );
        }

        return $client;
    }
}
