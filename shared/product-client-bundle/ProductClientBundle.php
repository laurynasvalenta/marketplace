<?php

namespace Shared\ProductClientBundle;

use Shared\ProductClientBundle\DependencyInjection\ProductClientExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProductClientBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ProductClientExtension();
    }
}
