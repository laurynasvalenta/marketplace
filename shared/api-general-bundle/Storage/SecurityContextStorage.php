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
     * @return SecurityContext
     */
    public function getSecurityContext(): ?SecurityContext
    {
        return $this->securityContext;
    }

    /**
     * @param SecurityContext $securityContext
     *
     * @return void
     */
    public function setSecurityContext(SecurityContext $securityContext): void
    {
        $this->securityContext = $securityContext;
    }
}
