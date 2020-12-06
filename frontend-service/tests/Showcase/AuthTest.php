<?php

namespace App\Tests\Showcase;

use Faker\Factory;
use Faker\Generator;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\UserDto\Dto\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthTest extends WebTestCase
{
    /**
     * @var AuthClientInterface
     */
    private $authClient;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $this->authClient = $container->get(AuthClientInterface::class);
        $this->faker = Factory::create();
    }

    /**
     * @test
     *
     * @return void
     */
    public function customerCanRegister(): void
    {
        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setPassword($this->faker->password);

        $this->authClient->createUser($user);

        $createdUser = $this->authClient->findUserByEmailAndPassword($user->getEmail(), $user->getPassword());

        $this->assertNotEmpty($createdUser->getUuid());
        $this->assertEmpty($createdUser->getPassword());
        $this->assertEquals($user->getEmail(), $createdUser->getEmail());
    }

    /**
     * @test
     *
     * @return void
     */
    public function duplicatedEmailFails(): void
    {
        $this->expectException(BadRequestResourceException::class);

        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setPassword($this->faker->password);

        $this->authClient->createUser($user);
        $this->authClient->createUser($user);
    }
}
