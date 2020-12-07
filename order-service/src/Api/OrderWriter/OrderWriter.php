<?php

namespace App\Api\OrderWriter;

use App\Entity\Order as OrderEntity;
use Doctrine\ORM\EntityManagerInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\ApiGeneralBundle\Storage\SecurityContextStorageInterface;
use Shared\OrderDto\Dto\Order;
use Shared\ProductClientBundle\ProductClientInterface;
use Shared\ProductDto\Dto\Product;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ProductClientInterface $productClient
     * @param SecurityContextStorageInterface $securityContextStorage
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ProductClientInterface $productClient,
        SecurityContextStorageInterface $securityContextStorage,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->productClient = $productClient;
        $this->securityContextStorage = $securityContextStorage;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function createOrder(Order $order): Order
    {
        $product = $this->productClient->findProduct((string)$order->getProductUuid());
        $orderEntity = $this->transformDtoToEntity($order, $product);

        $errors = $this->validator->validate($orderEntity);

        if ($errors->count() > 0) {
            throw new BadRequestResourceException($errors->get(0)->getMessage());
        }

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

    /**
     * @param Order $order
     * @param Product $product
     *
     * @return OrderEntity
     *
     * @throws UnauthorizedResourceException
     */
    protected function transformDtoToEntity(Order $order, Product $product): OrderEntity
    {
        $orderEntity = new OrderEntity();
        $orderEntity->setOwnerUuid($this->getOwnerId());
        $orderEntity->setProductUuid((string)$order->getProductUuid());
        $orderEntity->setProductOwnerUuid((string)$product->getOwnerUuid());
        $orderEntity->setProductQuantity((int)$product->getQuantity());
        $orderEntity->setProductName((string)$product->getName());
        $orderEntity->setProductDescription((string)$product->getDescription());
        $orderEntity->setProductPriceAmount((int)$product->getPriceAmount());
        $orderEntity->setProductPriceCurrency((string)$product->getPriceCurrency());
        $orderEntity->setOrderQuantity((int)$order->getQuantity());
        $orderEntity->setPaidPriceAmount((int)$product->getPriceAmount());
        $orderEntity->setPaidPriceCurrency((string)$product->getPriceCurrency());

        return $orderEntity;
    }
}
