<?php

namespace Shared\ApiGeneralBundle\Dto;

class SecurityContext
{
    private const IDENTIFIER_ANONYMOUS = 'anonymous';

    /**
     * @var bool
     */
    private $anonymous = true;

    /**
     * @var string
     */
    private $userIdentifier = self::IDENTIFIER_ANONYMOUS;

    /**
     * @return bool
     */
    public function getAnonymous(): bool
    {
        return $this->anonymous;
    }

    /**
     * @param bool $anonymous
     */
    public function setAnonymous(bool $anonymous): void
    {
        $this->anonymous = $anonymous;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @param string $userIdentifier
     */
    public function setUserIdentifier(string $userIdentifier): void
    {
        $this->userIdentifier = $userIdentifier;
    }
}
