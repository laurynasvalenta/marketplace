<?php

namespace Shared\ApiClientSecurityBundle\Factory;

use Psr\Http\Client\ClientInterface;
use Shared\ApiClientSecurityBundle\Client\BaseUrlProviderInterface;

interface ClientFactoryInterface
{
    /**
     * @param BaseUrlProviderInterface $baseUrlProvider
     *
     * @return ClientInterface
     */
    public function createClient(BaseUrlProviderInterface $baseUrlProvider): ClientInterface;
}
