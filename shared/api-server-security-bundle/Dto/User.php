<?php

namespace Shared\ApiServerSecurityBundle\Dto;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private const ROLE_USER = 'ROLE_USER';

    /**
     * @var string
     */
    private $uuid = '';

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return [self::ROLE_USER];
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        throw new \RuntimeException('Not implemented.');
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
