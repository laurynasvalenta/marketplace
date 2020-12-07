<?php

namespace Shared\ProductClientBundle;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\ProductDto\Dto\Product;

interface ProductClientInterface
{
    /**
     * @param Product $product
     *
     * @return Product
     *
     * @throws ResourceExceptionInterface
     */
    public function createProduct(Product $product): Product;

    /**
     * @param string $uuid
     *
     * @return Product
     *
     * @throws ResourceExceptionInterface
     */
    public function findProduct(string $uuid): Product;
}
