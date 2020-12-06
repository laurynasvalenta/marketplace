<?php

namespace Shared\ApiGeneralBundle\Exception\Resource;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedResourceException extends Exception implements ResourceExceptionInterface
{
    /**
     * {@inheritDoc}
     */
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
