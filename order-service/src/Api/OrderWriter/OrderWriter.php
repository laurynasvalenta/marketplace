<?php

namespace App\Api\OrderWriter;

use App\Entity\Order as OrderEntity;
use Doctrine\ORM\EntityManagerInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\ApiGeneralBundle\Storage\SecurityContextStorageInterface;
use Shared\OrderDto\Dto\Order;
use Shared\ProductClientBundle\ProductClientInterface;
use Throwable;

class OrderWriter implements OrderWriterInterface
{
    /**
     * @var ProductClientInterface
     */
    private $productClient;

    /**
     * @var SecurityContextStorageInterface
     */
    private $securityContextStorage;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ProductClientInterface $productClient
     * @param SecurityContextStorageInterface $securityContextStorage
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ProductClientInterface $productClient,
        SecurityContextStorageInterface $securityContextStorage,
        EntityManagerInterface $entityManager
    ) {
        $this->productClient = $productClient;
        $this->securityContextStorage = $securityContextStorage;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function createOrder(Order $order): Order
    {
        $product = $this->productClient->findProduct((string)$order->getProductUuid());

        $orderEntity = new OrderEntity();
        $orderEntity->setOwnerUuid($this->getOwnerId());
        $orderEntity->setProductUuid((string)$order->getProductUuid());
        $orderEntity->setQuantity((int)$order->getQuantity());
        $orderEntity->setProductName($product->getName());
        $orderEntity->setProductDescription($product->getDescription());
        $orderEntity->setProductPriceAmount($product->getPriceAmount());
        $orderEntity->setProductPriceCurrency($product->getPriceCurrency());
        $orderEntity->setPaidPriceAmount($product->getPriceAmount());
        $orderEntity->setPaidPriceCurrency($product->getPriceCurrency());

        try {
            $this->entityManager->persist($orderEntity);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new BadRequestResourceException();
        }

        $order->setUuid($orderEntity->getUuid());
        $order->setOwnerUuid($orderEntity->getOwnerUuid());
        $order->setPaidPriceAmount($product->getPriceAmount());
        $order->setPaidPriceCurrency($product->getPriceCurrency());

        return $order;
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
