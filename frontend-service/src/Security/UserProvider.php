<?php

namespace App\Security;

use Shared\AuthClientBundle\AuthClientInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    /**
     * @var AuthClientInterface
     */
    private $authClient;

    /**
     * @param AuthClientInterface $authClient
     */
    public function __construct(AuthClientInterface $authClient)
    {
        $this->authClient = $authClient;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername(string $username)
    {
        $user = $this->authClient->findUserByEmail($username);

        $userEntity = new User();
        $userEntity->setEmail($user->getEmail());
        $userEntity->setUuid($user->getUuid());

        return $userEntity;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->loadUserByUsername($user->getEmail());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass(string $class)
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    /**
     * {@inheritDoc}
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
    }
}
