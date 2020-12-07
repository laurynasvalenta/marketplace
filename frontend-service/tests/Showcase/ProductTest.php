<?php

namespace App\Tests\Showcase;

use App\Security\UserSetter;
use Faker\Factory;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\ProductClientBundle\ProductClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    use CustomerLoginTrait;
    use ProductCreateTrait;

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
        $this->userSetter = $container->get(UserSetter::class);
        $this->faker = Factory::create();
    }

    /**
     * @test
     *
     * @return void
     */
    public function customerCanCreateProduct(): void
    {
        $this->loginAsACustomer();

        $newProduct = $this->createProduct();
        $fetchedProduct = $this->productClient->findProduct($newProduct->getUuid());

        $this->assertEquals($newProduct->getUuid(), $fetchedProduct->getUuid());
        $this->assertEquals($newProduct->getDescription(), $fetchedProduct->getDescription());
        $this->assertEquals($newProduct->getQuantityAvailable(), $fetchedProduct->getQuantityAvailable());
        $this->assertEquals($newProduct->getPriceAmount(), $fetchedProduct->getPriceAmount());
        $this->assertEquals($newProduct->getPriceCurrency(), $fetchedProduct->getPriceCurrency());
        $this->assertEquals($newProduct->getOwnerUuid(), $fetchedProduct->getOwnerUuid());
        $this->assertEquals($newProduct->getName(), $fetchedProduct->getName());
    }

    /**
     * @test
     *
     * @return void
     */
    public function anonymousCustomerCannotCreateProducts(): void
    {
        $this->expectException(UnauthorizedResourceException::class);

        $this->createProduct();
    }
}
