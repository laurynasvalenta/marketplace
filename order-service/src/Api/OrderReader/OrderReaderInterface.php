<?php

namespace App\Api\OrderReader;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\OrderDto\Dto\Order;

interface OrderReaderInterface
{
    /**
     * @param string $orderUuid
     *
     * @return Order
     *
     * @throws ResourceExceptionInterface
     */
    public function findOrder(string $orderUuid): Order;
}
