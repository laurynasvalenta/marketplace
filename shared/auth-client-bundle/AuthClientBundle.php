<?php

namespace Shared\AuthClientBundle;

use Shared\AuthClientBundle\DependencyInjection\AuthClientExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AuthClientBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AuthClientExtension();
    }
}
