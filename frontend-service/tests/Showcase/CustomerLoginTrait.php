<?php

namespace App\Tests\Showcase;

use App\Security\UserSetter;
use Faker\Generator;
use Shared\AuthClientBundle\AuthClientInterface;
use Shared\UserDto\Dto\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait CustomerLoginTrait
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var AuthClientInterface
     */
    private $authClient;

    /**
     * @var UserSetter
     */
    private $userSetter;

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
