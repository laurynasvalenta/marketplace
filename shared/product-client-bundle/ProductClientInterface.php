<?php

namespace Shared\ProductClientBundle;

use Shared\ProductDto\Dto\Product;

interface ProductClientInterface
{
    /**
     * @param Product $product
     *
     * @return Product
     */
    public function createProduct(Product $product): Product;

    /**
     * @param string $uuid
     *
     * @return Product
     */
    public function findProduct(string $uuid): Product;
}
