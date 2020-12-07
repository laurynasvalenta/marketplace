<?php

namespace Shared\ApiGeneralBundle\Utils;

use Psr\Http\Message\ResponseInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Throwable;

class ErrorHandler
{
    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @param DecoderInterface $decoder
     */
    public function __construct(DecoderInterface $decoder)
    {
        $this->decoder = $decoder;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws ResourceExceptionInterface
     */
    public function handleResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            $this->handleBadRequestError($response);
        }

        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedResourceException();
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws ResourceExceptionInterface
     */
    private function handleBadRequestError(ResponseInterface $response): void
    {
        try {
            $exception = $this->decoder->decode((string)$response->getBody(), 'json');
        } catch (Throwable $e) {
        }

        if (empty($exception['message']) === false) {
            throw new BadRequestResourceException($exception['message']);
        }

        throw new BadRequestResourceException();
    }
}
