<?php

namespace Shared\ApiGeneralBundle\Exception\Resource;

use Throwable;

interface ResourceExceptionInterface extends Throwable
{
    /**
     * @return int
     */
    public function getHttpResponseCode(): int;
}
