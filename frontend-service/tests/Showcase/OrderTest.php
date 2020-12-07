<?php

namespace App\Tests\Showcase;

use App\Security\UserSetter;
use Faker\Factory;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\OrderDto\Dto\Order;
use Shared\OrderClientBundle\OrderClientInterface;
use Shared\ProductClientBundle\ProductClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderTest extends WebTestCase
{
    use CustomerLoginTrait;
    use ProductCreateTrait;

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

        $this->assertEquals($order->getUuid(), $fetchedOrder->getUuid());
        $this->assertEquals($order->getProductUuid(), $fetchedOrder->getProductUuid());
        $this->assertEquals($order->getQuantity(), $fetchedOrder->getQuantity());
        $this->assertEquals($order->getPaidPriceAmount(), $fetchedOrder->getPaidPriceAmount());
        $this->assertEquals($order->getPaidPriceCurrency(), $fetchedOrder->getPaidPriceCurrency());
    }
}
