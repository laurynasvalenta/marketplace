<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserSetter
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param UserProvider $userProvider
     */
    public function __construct(TokenStorageInterface $tokenStorage, UserProvider $userProvider)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userProvider = $userProvider;
    }

    /**
     * @param TokenInterface $token
     *
     * @return void
     */
    public function setToken(TokenInterface $token): void
    {
        $this->tokenStorage->setToken($token);
    }

    /**
     * @return UserProviderInterface
     */
    public function getUserProvider(): UserProviderInterface
    {
        return $this->userProvider;
    }
}
