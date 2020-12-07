<?php

namespace App\Api\OrderReader;

use Shared\OrderDto\Dto\Order;

interface OrderReaderInterface
{
    /**
     * @param string $orderUuid
     *
     * @return Order
     */
    public function findOrder(string $orderUuid): Order;
}
