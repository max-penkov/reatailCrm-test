<?php

namespace Client\Entity;

/**
 * Interface HistoryOwnerInterface
 * @package Client\Entity
 */
interface HistoryOwnerInterface
{
    /**
     * @return mixed
     */
    public function getOwner();

    /**
     * @param $owner
     *
     * @return HistoryOwnerInterface
     */
    public function setOwner($owner): HistoryOwnerInterface;
}
