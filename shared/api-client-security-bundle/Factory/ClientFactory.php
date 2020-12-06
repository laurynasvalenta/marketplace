<?php

namespace Shared\ApiClientSecurityBundle\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Shared\ApiClientSecurityBundle\Client\BaseUrlProviderInterface;
use Shared\ApiClientSecurityBundle\Provider\AuthorizationHeaderProviderInterface;

class ClientFactory implements ClientFactoryInterface
{
    /**
     * @var AuthorizationHeaderProviderInterface
     */
    private $headerProvider;

    /**
     * @param AuthorizationHeaderProviderInterface $headerProvider
     */
    public function __construct(AuthorizationHeaderProviderInterface $headerProvider)
    {
        $this->headerProvider = $headerProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function createClient(BaseUrlProviderInterface $baseUrlProvider): ClientInterface
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push($this->buildMiddleware());

        return new Client(
            [
                'base_uri' => $baseUrlProvider->getBaseUrl(),
                'handler' => $stack,
            ]
        );
    }

    /**
     * @return callable
     */
    protected function buildMiddleware(): callable
    {
        return Middleware::mapRequest(function (RequestInterface $request) {
            foreach ($this->headerProvider->buildHeadersMap() as $headerName => $value) {
                $request = $request->withHeader($headerName, $value);
            }

            return $request;
        });
    }
}
