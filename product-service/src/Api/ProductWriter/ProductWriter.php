<?php

namespace App\Api\ProductWriter;

use App\Entity\Product as ProductEntity;
use Doctrine\ORM\EntityManagerInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\ApiGeneralBundle\Storage\SecurityContextStorageInterface;
use Shared\ProductDto\Dto\Product;
use Throwable;

class ProductWriter implements ProductWriterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SecurityContextStorageInterface
     */
    private $securityContextStorage;

    /**
     * @param EntityManagerInterface $entityManager
     * @param SecurityContextStorageInterface $securityContextStorage
     */
    public function __construct(EntityManagerInterface $entityManager, SecurityContextStorageInterface $securityContextStorage)
    {
        $this->entityManager = $entityManager;
        $this->securityContextStorage = $securityContextStorage;
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function createProduct(Product $product): Product
    {
        $productEntity = new ProductEntity();
        $productEntity->setName($product->getName());
        $productEntity->setDescription($product->getDescription());
        $productEntity->setQuantityAvailable($product->getQuantityAvailable());
        $productEntity->setPriceAmount($product->getPriceAmount());
        $productEntity->setPriceCurrency($product->getPriceCurrency());
        $productEntity->setOwnerUuid($this->getOwnerId());

        try {
            $this->entityManager->persist($productEntity);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new BadRequestResourceException();
        }

        $product->setUuid($productEntity->getUuid());
        $product->setOwnerUuid($productEntity->getOwnerUuid());

        return $product;
    }

    /**
     * @return string
     */
    private function getOwnerId(): string
    {
        $securityContext = $this->securityContextStorage->getSecurityContext();

        if ($securityContext === null || $securityContext->getAnonymous() === true) {
            throw new UnauthorizedResourceException();
        }

        return $securityContext->getUserIdentifier();
    }
}
