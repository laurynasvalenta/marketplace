<?php

namespace Shared\ApiGeneralBundle\Storage;

use Shared\ApiGeneralBundle\Dto\SecurityContext;

class SecurityContextStorage implements SecurityContextStorageInterface
{
    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * {@inheritDoc}
     */
    public function getSecurityContext(): ?SecurityContext
    {
        return $this->securityContext;
    }

    /**
     * {@inheritDoc}
     */
    public function setSecurityContext(SecurityContext $securityContext): void
    {
        $this->securityContext = $securityContext;
    }
}
