<?php

namespace Shared\ApiGeneralBundle\Storage;

use Shared\ApiGeneralBundle\Dto\SecurityContext;

interface SecurityContextStorageInterface
{
    /**
     * @return SecurityContext|null
     */
    public function getSecurityContext(): ?SecurityContext;

    /**
     * @param SecurityContext $securityContext
     *
     * @return void
     */
    public function setSecurityContext(SecurityContext $securityContext): void;
}
