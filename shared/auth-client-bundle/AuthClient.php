<?php

namespace Shared\AuthClientBundle;

use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\ApiClientSecurityBundle\Client\BaseUrlProviderInterface;
use Shared\ApiClientSecurityBundle\Factory\ClientFactoryInterface;
use Shared\UserDto\Dto\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AuthClient implements AuthClientInterface, BaseUrlProviderInterface
{
    private const URI_USER = '/api/user';

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
     * {@inheritDoc}
     */
    public function createUser(User $user): void
    {
        $request = new Request('POST', self::URI_USER, [], $this->serializer->serialize($user, 'json'));
        
        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            throw new BadRequestResourceException();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByEmail(string $email): User
    {
        $uri = new Uri(self::URI_USER);
        $uri = $uri->withQuery(Query::build(['email' => $email]));

        return $this->findUser($uri);
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByEmailAndPassword(string $email, string $password): User
    {
        $uri = new Uri(self::URI_USER);
        $uri = $uri->withQuery(Query::build(['email' => $email, 'password' => $password]));

        return $this->findUser($uri);
    }

    /**
     * @param Uri $uri
     *
     * @return User
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    protected function findUser(Uri $uri): User
    {
        $request = new Request('GET', $uri);
        $response = $this->httpClient->sendRequest($request);

        /** @var User $user  */
        $user = $this->serializer->deserialize((string)$response->getBody(), User::class, 'json');

        return $user;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }
}
