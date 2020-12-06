<?php

namespace App\Tests\Showcase;

use App\Security\UserSetter;
use Faker\Factory;
use Faker\Generator;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\ProductClientBundle\ProductClientInterface;
use Shared\ProductDto\Dto\Product;
use Shared\UserDto\Dto\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ProductTest extends WebTestCase
{
    /**
     * @var ProductClientInterface
     */
    private $productClient;

    /**
     * @var AuthClientInterface
     */
    private $authClient;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var UserSetter
     */
    private $userSetter;

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

        $newProduct = new Product();
        $newProduct->setName($this->faker->name);
        $newProduct->setDescription($this->faker->text(455));
        $newProduct->setPriceAmount(1995);
        $newProduct->setPriceCurrency($this->faker->currencyCode);
        $newProduct->setQuantityAvailable(6);

        $newProduct = $this->productClient->createProduct($newProduct);

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

        $newProduct = new Product();
        $newProduct->setName($this->faker->name);
        $newProduct->setDescription($this->faker->text(455));
        $newProduct->setPriceAmount(1995);
        $newProduct->setPriceCurrency($this->faker->currencyCode);
        $newProduct->setQuantityAvailable(6);

        $this->productClient->createProduct($newProduct);
    }

    /**
     * @return void
     */
    private function loginAsACustomer(): void
    {
        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setPassword($this->faker->password);

        $this->authClient->createUser($user);

        $token = new UsernamePasswordToken(
            $this->userSetter->getUserProvider()->loadUserByUsername($user->getEmail()),
            $user->getPassword(),
            'main'
        );

        $this->userSetter->setToken($token);
    }
}
