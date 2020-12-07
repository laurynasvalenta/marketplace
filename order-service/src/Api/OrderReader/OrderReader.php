<?php

namespace App\Api\OrderReader;

use App\Repository\OrderRepository;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceNotFoundException;
use Shared\OrderDto\Dto\Order;

class OrderReader implements OrderReaderInterface
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function findOrder(string $orderUuid): Order
    {
        $orderEntity = $this->repository->find($orderUuid);

        if ($orderEntity === null) {
            throw new ResourceNotFoundException();
        }

        $order = new Order();
        $order->setUuid($orderEntity->getUuid());
        $order->setPaidPriceAmount($orderEntity->getPaidPriceAmount());
        $order->setPaidPriceCurrency($orderEntity->getPaidPriceCurrency());
        $order->setOwnerUuid($orderEntity->getOwnerUuid());
        $order->setQuantity($orderEntity->getOrderQuantity());
        $order->setProductUuid($orderEntity->getProductUuid());

        return $order;
    }
}
