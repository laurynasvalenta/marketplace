<?php

namespace Shared\OrderClientBundle;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientInterface;
use Shared\ApiClientSecurityBundle\Client\BaseUrlProviderInterface;
use Shared\ApiClientSecurityBundle\Factory\ClientFactoryInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceNotFoundException;
use Shared\ApiGeneralBundle\Exception\Resource\UnauthorizedResourceException;
use Shared\OrderDto\Dto\Order;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class OrderClient implements OrderClientInterface, BaseUrlProviderInterface
{
    private const URI_ORDER = '/api/order';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiBaseUrl;

    /**
     * @param SerializerInterface $serializer
     * @param ClientFactoryInterface $httpClientFactory
     * @param string $apiBaseUrl
     */
    public function __construct(
        SerializerInterface $serializer,
        ClientFactoryInterface $httpClientFactory,
        string $apiBaseUrl
    ) {
        $this->apiBaseUrl = $apiBaseUrl;

        $this->serializer = $serializer;
        $this->httpClient = $httpClientFactory->createClient($this);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function createOrder(Order $order): Order
    {
        $request = new Request('POST', self::URI_ORDER, [], $this->serializer->serialize($order, 'json'));

        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            throw new BadRequestResourceException();
        }

        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedResourceException();
        }

        /**
         * @var Order $order
         */
        $order = $this->serializer->deserialize((string)$response->getBody(), Order::class, 'json');

        return $order;
    }

    /**
     * {@inheritDoc}
     */
    public function findOrder(string $orderUuid): Order
    {
        $uri = new Uri(sprintf('%s/%s', self::URI_ORDER, $orderUuid));
        $request = new Request('GET', $uri);
        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new ResourceNotFoundException();
        }

        /**
         * @var Order $order
         */
        $order = $this->serializer->deserialize((string)$response->getBody(), Order::class, 'json');

        return $order;
    }
}
