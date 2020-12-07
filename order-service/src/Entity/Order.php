<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Validator;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="`order`")
 * @Validator\CorrectOwner
 * @Validator\AvailableQuantity
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @ORM\Column(type="uuid")
     *
     * @var string
     */
    private $uuid;

    /**
     * @ORM\Column(type="uuid")
     *
     * @var string
     */
    private $ownerUuid;

    /**
     * @ORM\Column(type="uuid")
     *
     * @var string
     */
    private $productUuid;

    /**
     * @ORM\Column(type="uuid")
     *
     * @var string
     */
    private $productOwnerUuid;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $orderQuantity;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $productQuantity;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $productName;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $productDescription;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $productPriceAmount;

    /**
     * @ORM\Column(type="string", length=3)
     *
     * @var string
     */
    private $productPriceCurrency;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $paidPriceAmount;

    /**
     * @ORM\Column(type="string", length=3)
     *
     * @var string
     */
    private $paidPriceCurrency;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getUuid(): string
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
     * @return string
     */
    public function getOwnerUuid(): string
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
     * @return string
     */
    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    /**
     * @param string $productUuid
     *
     * @return void
     */
    public function setProductUuid(string $productUuid): void
    {
        $this->productUuid = $productUuid;
    }

    /**
     * @return string
     */
    public function getProductOwnerUuid(): string
    {
        return $this->productOwnerUuid;
    }

    /**
     * @param string $productOwnerUuid
     *
     * @return void
     */
    public function setProductOwnerUuid(string $productOwnerUuid): void
    {
        $this->productOwnerUuid = $productOwnerUuid;
    }

    /**
     * @return int
     */
    public function getOrderQuantity(): int
    {
        return $this->orderQuantity;
    }

    /**
     * @param int $orderQuantity
     *
     * @return void
     */
    public function setOrderQuantity(int $orderQuantity): void
    {
        $this->orderQuantity = $orderQuantity;
    }

    /**
     * @return int
     */
    public function getProductQuantity(): int
    {
        return $this->productQuantity;
    }

    /**
     * @param int $productQuantity
     *
     * @return void
     */
    public function setProductQuantity(int $productQuantity): void
    {
        $this->productQuantity = $productQuantity;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     *
     * @return void
     */
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
    }

    /**
     * @param string $productDescription
     *
     * @return void
     */
    public function setProductDescription(string $productDescription): void
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @return int
     */
    public function getProductPriceAmount(): int
    {
        return $this->productPriceAmount;
    }

    /**
     * @param int $productPriceAmount
     *
     * @return void
     */
    public function setProductPriceAmount(int $productPriceAmount): void
    {
        $this->productPriceAmount = $productPriceAmount;
    }

    /**
     * @return string
     */
    public function getProductPriceCurrency(): string
    {
        return $this->productPriceCurrency;
    }

    /**
     * @param string $productPriceCurrency
     *
     * @return void
     */
    public function setProductPriceCurrency(string $productPriceCurrency): void
    {
        $this->productPriceCurrency = $productPriceCurrency;
    }

    /**
     * @return int
     */
    public function getPaidPriceAmount(): int
    {
        return $this->paidPriceAmount;
    }

    /**
     * @param int $paidPriceAmount
     *
     * @return void
     */
    public function setPaidPriceAmount(int $paidPriceAmount): void
    {
        $this->paidPriceAmount = $paidPriceAmount;
    }

    /**
     * @return string
     */
    public function getPaidPriceCurrency(): string
    {
        return $this->paidPriceCurrency;
    }

    /**
     * @param string $paidPriceCurrency
     *
     * @return void
     */
    public function setPaidPriceCurrency(string $paidPriceCurrency): void
    {
        $this->paidPriceCurrency = $paidPriceCurrency;
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
