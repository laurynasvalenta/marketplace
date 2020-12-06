<?php

namespace App\Api\ProductReader;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\ProductDto\Dto\Product;

interface ProductReaderInterface
{
    /**
     * @param string $uuid
     *
     * @return Product
     *
     * @throws ResourceExceptionInterface
     */
    public function findProduct(string $uuid): Product;
}
