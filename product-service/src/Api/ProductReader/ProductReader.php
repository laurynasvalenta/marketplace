<?php

namespace App\Api\ProductReader;

use App\Repository\ProductRepository;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceNotFoundException;
use Shared\ProductDto\Dto\Product;

class ProductReader implements ProductReaderInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function findProduct(string $uuid): Product
    {
        $productEntity = $this->productRepository->find($uuid);

        if ($productEntity === null) {
            throw new ResourceNotFoundException();
        }

        $product = new Product();
        $product->setUuid($productEntity->getUuid());
        $product->setName($productEntity->getName());
        $product->setOwnerUuid($productEntity->getOwnerUuid());
        $product->setPriceCurrency($productEntity->getPriceCurrency());
        $product->setPriceAmount($productEntity->getPriceAmount());
        $product->setQuantityAvailable($productEntity->getQuantityAvailable());
        $product->setDescription($productEntity->getDescription());

        return $product;
    }
}
