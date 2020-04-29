<?php

declare(strict_types=1);

namespace Client\Entity;

use Core\Entity\History;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ClientHistory
 * @package Client\Entity
 * @ORM\Entity()
 */
class ClientHistory extends History implements HistoryOwnerInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="histories")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id", nullable=false)
     */
    private $owner;

    /**
     * @return mixed
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