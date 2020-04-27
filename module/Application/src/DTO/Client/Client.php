<?php

declare(strict_types=1);

namespace Application\DTO\Client;

use Client\Entity\Client as ClientEntity;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * * @OA\Schema(
 *     title="Client schema"
 * )
 *
 * Class Client
 * @package Application\DTO\Project
 */
class Client
{
    /**
     ** @OA\Property(
     *     description="Id",
     * )
     * @var string
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     * @OA\Property(
     *     description="Name",
     *     required={"name"}
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @param ClientEntity $project
     *
     * @return static
     */
    public static function buildFromClient(ClientEntity $project): self
    {
        $obj = new self();

        $obj->id          = $project->getId();
        $obj->name        = $project->getName();

        return $obj;
    }
}
