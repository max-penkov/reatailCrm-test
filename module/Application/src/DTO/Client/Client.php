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
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Email()
     * @OA\Property(
     *     description="Email",
     *     required={"email"}
     * )
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min="6", max="10")
     * @OA\Property(
     *     description="Phone",
     * )
     * @var string
     */
    public $phone;

    /**
     * @param ClientEntity $client
     *
     * @return static
     */
    public static function buildFromClient(ClientEntity $client): self
    {
        $obj = new self();

        $obj->id    = $client->getId();
        $obj->name  = $client->getName();
        $obj->email = $client->getEmail();
        $obj->phone = $client->getPhone();

        return $obj;
    }
}
