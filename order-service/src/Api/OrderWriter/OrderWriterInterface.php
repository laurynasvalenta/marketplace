<?php

namespace App\Api\OrderWriter;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\OrderDto\Dto\Order;

interface OrderWriterInterface
{
    /**
     * @param Order $order
     *
     * @return Order
     *
     * @throws ResourceExceptionInterface
     */
    public function createOrder(Order $order): Order;
}
