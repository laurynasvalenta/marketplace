<?php

namespace Shared\ApiGeneralBundle\Exception\Resource;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends Exception implements ResourceExceptionInterface
{
    /**
     * {@inheritDoc}
     */
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
