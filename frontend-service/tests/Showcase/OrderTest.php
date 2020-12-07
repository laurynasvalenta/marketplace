<?php

namespace App\Tests\Showcase;

use App\Security\UserSetter;
use Faker\Factory;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\OrderDto\Dto\Order;
use Shared\OrderClientBundle\OrderClientInterface;
use Shared\ProductClientBundle\ProductClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderTest extends WebTestCase
{
    use CustomerLoginTrait;
    use ProductCreateTrait;

    private const SAME_OWNER_ERROR_MESSAGE = 'error.owner.same';

    /**
     * @var OrderClientInterface
     */
    private $orderClient;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $this->authClient = $container->get(AuthClientInterface::class);
        $this->productClient = $container->get(ProductClientInterface::class);
        $this->orderClient = $container->get(OrderClientInterface::class);
        $this->userSetter = $container->get(UserSetter::class);
        $this->faker = Factory::create();
    }

    /**
     * @test
     *
     * @return void
     */
    public function customerCanPlaceAnOrder(): void
    {
        $this->loginAsACustomer();
        $product = $this->createProduct();

        /* Log in as another customer */
        $this->loginAsACustomer();

        $order = new Order();
        $order->setProductUuid($product->getUuid());
        $order->setQuantity(2);

        $order = $this->orderClient->createOrder($order);
        $fetchedOrder = $this->orderClient->findOrder($order->getUuid());

        $this->assertSameOrder($order, $fetchedOrder);
    }

    /**
     * @test
     *
     * @return void
     */
    public function customerCannotPlaceAnOrderForHisOwnProduct(): void
    {
        $this->expectException(BadRequestResourceException::class);
        $this->expectErrorMessage(self::SAME_OWNER_ERROR_MESSAGE);

        $this->loginAsACustomer();
        $product = $this->createProduct();

        $order = new Order();
        $order->setProductUuid($product->getUuid());
        $order->setQuantity(2);

        $this->orderClient->createOrder($order);
    }

    /**
     * @test
     *
     * @return void
     */
    public function buyerCannotOrderMoreItemsThanSellerSells(): void
    {
        $this->loginAsACustomer();
        $product = $this->createProduct();

        /* Log in as another customer */
        $this->loginAsACustomer();

        $order = new Order();
        $order->setProductUuid($product->getUuid());
        $order->setQuantity(4);

        $this->orderClient->createOrder(clone $order);

        $this->expectException(BadRequestResourceException::class);
        $this->orderClient->createOrder(clone $order);
    }

    /**
     * @param Order $order
     * @param Order $fetchedOrder
     *
     * @return void
     */
    protected function assertSameOrder(Order $order, Order $fetchedOrder): void
    {
        $this->assertEquals($order->getUuid(), $fetchedOrder->getUuid());
        $this->assertEquals($order->getProductUuid(), $fetchedOrder->getProductUuid());
        $this->assertEquals($order->getQuantity(), $fetchedOrder->getQuantity());
        $this->assertEquals($order->getPaidPriceAmount(), $fetchedOrder->getPaidPriceAmount());
        $this->assertEquals($order->getPaidPriceCurrency(), $fetchedOrder->getPaidPriceCurrency());
    }
}
