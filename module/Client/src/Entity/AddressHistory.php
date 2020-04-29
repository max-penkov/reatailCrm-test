<?php

declare(strict_types=1);

namespace Client\Entity;

use Core\Entity\History;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AddressHistory
 * @package Client\Entity
 * @ORM\Entity()
 */
class AddressHistory extends History implements HistoryOwnerInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="histories")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id", nullable=false)
     */
    private $owner;

    /**
     * @retu
     * rn mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $owner
     *
     * @return HistoryOwnerInterface
     */
    public function setOwner($owner): HistoryOwnerInterface
    {
        $this->owner = $owner;
        return $this;
    }
}