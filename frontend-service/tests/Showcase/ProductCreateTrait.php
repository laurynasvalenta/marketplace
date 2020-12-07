<?php

namespace App\Tests\Showcase;

use Faker\Generator;
use Shared\ProductClientBundle\ProductClientInterface;
use Shared\ProductDto\Dto\Product;

trait ProductCreateTrait
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var ProductClientInterface
     */
    private $productClient;

    /**
     * @return Product
     */
    private function createProduct(): Product
    {
        $newProduct = new Product();
        $newProduct->setName($this->faker->name);
        $newProduct->setDescription($this->faker->text(455));
        $newProduct->setPriceAmount(1995);
        $newProduct->setPriceCurrency($this->faker->currencyCode);
        $newProduct->setQuantityAvailable(6);

        return $this->productClient->createProduct($newProduct);
    }
}
