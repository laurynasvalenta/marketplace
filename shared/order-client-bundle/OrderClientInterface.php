<?php

namespace Shared\OrderClientBundle;

use Shared\OrderDto\Dto\Order;

interface OrderClientInterface
{
    /**
     * @param Order $order
     *
     * @return Order
     */
    public function createOrder(Order $order): Order;

    /**
     * @param string $orderUuid
     *
     * @return Order
     */
    public function findOrder(string $orderUuid): Order;
}
