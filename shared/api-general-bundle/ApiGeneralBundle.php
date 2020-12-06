<?php

namespace Shared\ApiGeneralBundle;

use Shared\ApiGeneralBundle\DependencyInjection\ApiGeneralExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiGeneralBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new ApiGeneralExtension();
    }
}
