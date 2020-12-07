<?php

namespace Shared\ProductDto\Dto;

class Product
{
    /**
     * @var string|null
     */
    private $uuid;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $quantity;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $ownerUuid;

    /**
     * @var int|null
     */
    private $priceAmount;

    /**
     * @var string|null
     */
    private $priceCurrency;

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     *
     * @return void
     */
    public function setUuid(?string $uuid): void
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
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     *
     * @return void
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void
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
     * @param string|null $ownerUuid
     *
     * @return void
     */
    public function setOwnerUuid(?string $ownerUuid): void
    {
        $this->ownerUuid = $ownerUuid;
    }

    /**
     * @return int|null
     */
    public function getPriceAmount(): ?int
    {
        return $this->priceAmount;
    }

    /**
     * @param int|null $priceAmount
     *
     * @return void
     */
    public function setPriceAmount(?int $priceAmount): void
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
     * @param string|null $priceCurrency
     *
     * @return void
     */
    public function setPriceCurrency(?string $priceCurrency): void
    {
        $this->priceCurrency = $priceCurrency;
    }
}
