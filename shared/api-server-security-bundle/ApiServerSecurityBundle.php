<?php

namespace Shared\ApiServerSecurityBundle;

use Shared\ApiServerSecurityBundle\DependencyInjection\ApiServerSecurityExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiServerSecurityBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new ApiServerSecurityExtension();
    }
}
