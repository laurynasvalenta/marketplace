<?php

namespace Shared\ApiClientSecurityBundle\Provider;

interface AuthorizationHeaderProviderInterface
{
    /**
     * @return array
     */
    public function buildHeadersMap(): array;
}
