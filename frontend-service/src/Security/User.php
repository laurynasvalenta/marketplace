<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private const ROLE_USER = 'ROLE_USER';

    /**
     * @var string|null
     */
    private $uuid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string[]
     */
    private $roles = [self::ROLE_USER];

    /**
     * @var string
     */
    private $password;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername(): string
    {
        return (string) $this->uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
    public function eraseCredentials()
    {
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid)
    {
        $this->uuid = $uuid;
    }
}
