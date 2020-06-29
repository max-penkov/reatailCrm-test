<?php

namespace Client\Entity;

use Core\Interfaces\HistorizableInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"name", "email"})
 */
class Client implements HistorizableInterface
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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="client", cascade={"all"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="ClientHistory", mappedBy="owner")
     */
    private $histories;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Client constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @throws \Exception
     */
    public function __construct(string $name, string $email, string $phone)
    {
        $this->name      = $name;
        $this->email     = $email;
        $this->phone     = $phone;
        $this->address   = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->histories = new ArrayCollection();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     */
    public function edit(string $name, string $email, string $phone)
    {
        $this->name  = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setClient($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getClient() === $this) {
                $address->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @return Collection
     */
    public function getHistories()
    {
        return $this->histories;
    }

    public function getHistoryClass(): string
    {
        return ClientHistory::class;
    }
}
