<?php

namespace App\Api\OrderWriter;

use Shared\OrderDto\Dto\Order;

interface OrderWriterInterface
{
    /**
     * @param Order $order
     *
     * @return Order
     */
    public function createOrder(Order $order): Order;
}
