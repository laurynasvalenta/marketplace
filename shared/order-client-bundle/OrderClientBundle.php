<?php

namespace Shared\OrderClientBundle;

use Shared\OrderClientBundle\DependencyInjection\OrderClientExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OrderClientBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new OrderClientExtension();
    }
}
