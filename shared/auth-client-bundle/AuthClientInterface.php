<?php

namespace Shared\AuthClientBundle;

use Shared\UserDto\Dto\User;

interface AuthClientInterface
{
    /**
     * @param User $user
     *
     * @return void
     */
    public function createUser(User $user): void;

    /**
     * @param string $email
     *
     * @return User
     */
    public function findUserByEmail(string $email): User;

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function findUserByEmailAndPassword(string $email, string $password): User;
}
