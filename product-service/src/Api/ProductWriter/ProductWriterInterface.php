<?php

namespace App\Api\ProductWriter;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\ProductDto\Dto\Product;

interface ProductWriterInterface
{
    /**
     * @param Product $product
     *
     * @return Product
     *
     * @throws ResourceExceptionInterface
     */
    public function createProduct(Product $product): Product;
}
