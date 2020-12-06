<?php

namespace Shared\ApiClientSecurityBundle;

use Shared\ApiClientSecurityBundle\DependencyInjection\ApiClientSecurityExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiClientSecurityBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new ApiClientSecurityExtension();
    }
}
