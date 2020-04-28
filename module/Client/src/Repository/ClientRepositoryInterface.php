<?php

namespace Client\Repository;

use Client\Entity\Client;
use Ds\Vector;

/**
 * Class ClientRepository
 * @package Client\Repository
 */
interface ClientRepositoryInterface
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Vector
     */
    public function fetchAll(int $limit, int $offset);

    /**
     * @return int
     */
    public function getTotal();

    /**
     * @param Client $client
     *
     * @return Client
     */
    public function save(Client $client): Client;

    /**
     * @param string $id
     *
     * @return Client
     */
    public function get(string $id): Client;
}
