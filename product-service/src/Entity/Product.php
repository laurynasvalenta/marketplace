<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @ORM\Column(type="uuid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityAvailable;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="uuid")
     */
    private $ownerUuid;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceAmount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $priceCurrency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return void
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getQuantityAvailable(): ?int
    {
        return $this->quantityAvailable;
    }

    /**
     * @param int $quantityAvailable
     *
     * @return void
     */
    public function setQuantityAvailable(int $quantityAvailable): void
    {
        $this->quantityAvailable = $quantityAvailable;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getOwnerUuid(): ?string
    {
        return $this->ownerUuid;
    }

    /**
     * @param string $ownerUuid
     *
     * @return void
     */
    public function setOwnerUuid(string $ownerUuid): void
    {
        $this->ownerUuid = $ownerUuid;
    }

    /**
     * @return int|null
     *
     * @return void
     */
    public function getPriceAmount(): ?int
    {
        return $this->priceAmount;
    }

    /**
     * @param int $priceAmount
     *
     * @return void
     */
    public function setPriceAmount(int $priceAmount): void
    {
        $this->priceAmount = $priceAmount;
    }

    /**
     * @return string|null
     */
    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    /**
     * @param string $priceCurrency
     *
     * @return void
     */
    public function setPriceCurrency(string $priceCurrency): void
    {
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return ?DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return ?DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime("now");
        $this->updatedAt = new DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime("now");
    }
}
