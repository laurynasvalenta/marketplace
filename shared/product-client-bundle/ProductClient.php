<?php

namespace Shared\ProductClientBundle;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiClientSecurityBundle\Client\BaseUrlProviderInterface;
use Shared\ApiClientSecurityBundle\Factory\ClientFactoryInterface;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceNotFoundException;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\ApiGeneralBundle\Utils\ErrorHandler;
use Shared\ProductDto\Dto\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProductClient implements ProductClientInterface, BaseUrlProviderInterface
{
    private const URI_PRODUCT = '/api/product';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    /**
     * @var string
     */
    private $apiBaseUrl;

    /**
     * @param SerializerInterface $serializer
     * @param ClientFactoryInterface $httpClientFactory
     * @param ErrorHandler $errorHandler
     * @param string $apiBaseUrl
     */
    public function __construct(
        SerializerInterface $serializer,
        ClientFactoryInterface $httpClientFactory,
        ErrorHandler $errorHandler,
        string $apiBaseUrl
    ) {
        $this->apiBaseUrl = $apiBaseUrl;

        $this->serializer = $serializer;
        $this->httpClient = $httpClientFactory->createClient($this);
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function createProduct(Product $product): Product
    {
        $request = new Request('POST', self::URI_PRODUCT, [], $this->serializer->serialize($product, 'json'));
        $response = $this->httpClient->sendRequest($request);

        $this->errorHandler->handleResponse($response);

        /** @var Product $product */
        $product = $this->serializer->deserialize((string)$response->getBody(), Product::class, 'json');

        return $product;
    }

    /**
     * @param string $uuid
     *
     * @return Product
     *
     * @throws ResourceNotFoundException
     */
    public function findProduct(string $uuid): Product
    {
        $uri = new Uri(sprintf('%s/%s', self::URI_PRODUCT, $uuid));
        $request = new Request('GET', $uri);
        $response = $this->httpClient->sendRequest($request);

        $this->errorHandler->handleResponse($response);

        /** @var Product $product */
        $product = $this->serializer->deserialize((string)$response->getBody(), Product::class, 'json');

        return $product;
    }
}
