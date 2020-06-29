<?php

namespace Client\Entity;

use Core\Interfaces\HistorizableInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Client\Repository\AddressRepository")
 */
class Address implements HistorizableInterface
{
    /**
     * @ORM\Column(type="guid", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("with_address")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("with_address")
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="Client\Entity\Client", inversedBy="address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="AddressHistory", mappedBy="owner")
     */
    private $histories;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    /**
     * @return string
     */
    public function getHistoryClass(): string
    {
        return AddressHistory::class;
    }
}
