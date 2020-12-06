<?php

namespace Shared\ApiGeneralBundle\Dto;

class SecurityContext
{
    private const IDENTIFIER_ANONYMOUS = 'anonymous';

    /**
     * @var bool
     */
    private $isAnonymous = true;

    /**
     * @var string
     */
    private $userIdentifier = self::IDENTIFIER_ANONYMOUS;

    /**
     * @return bool
     */
    public function isAnonymous(): bool
    {
        return $this->isAnonymous;
    }

    /**
     * @param bool $isAnonymous
     */
    public function setIsAnonymous(bool $isAnonymous): void
    {
        $this->isAnonymous = $isAnonymous;
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
