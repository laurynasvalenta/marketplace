<?php

namespace Shared\OrderDto\Dto;

class Order
{
    /**
     * @var string|null
     */
    private $uuid;

    /**
     * @var string|null
     */
    private $productUuid;

    /**
     * @var string|null
     */
    private $ownerUuid;

    /**
     * @var integer|null
     */
    private $quantity;

    /**
     * @var integer|null
     */
    private $paidPriceAmount;

    /**
     * @var string|null
     */
    private $paidPriceCurrency;

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
    public function getProductUuid(): ?string
    {
        return $this->productUuid;
    }

    /**
     * @param string|null $productUuid
     *
     * @return void
     */
    public function setProductUuid(?string $productUuid): void
    {
        $this->productUuid = $productUuid;
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
     * @return int|null
     */
    public function getPaidPriceAmount(): ?int
    {
        return $this->paidPriceAmount;
    }

    /**
     * @param int|null $paidPriceAmount
     *
     * @return void
     */
    public function setPaidPriceAmount(?int $paidPriceAmount): void
    {
        $this->paidPriceAmount = $paidPriceAmount;
    }

    /**
     * @return string|null
     */
    public function getPaidPriceCurrency(): ?string
    {
        return $this->paidPriceCurrency;
    }

    /**
     * @param string|null $paidPriceCurrency
     *
     * @return void
     */
    public function setPaidPriceCurrency(?string $paidPriceCurrency): void
    {
        $this->paidPriceCurrency = $paidPriceCurrency;
    }
}
