<?php

namespace Shared\ApiClientSecurityBundle\Client;

interface BaseUrlProviderInterface
{
    /**
     * @return string
     */
    public function getBaseUrl(): string;
}
