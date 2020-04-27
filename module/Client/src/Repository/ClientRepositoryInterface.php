<?php

namespace Client\Repository;

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
}
