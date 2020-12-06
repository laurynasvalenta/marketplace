<?php

namespace Shared\ApiServerSecurityBundle\Security;

use Firebase\JWT\JWT;
use Shared\ApiGeneralBundle\Storage\SecurityContextStorageInterface;
use Shared\ApiServerSecurityBundle\Dto\User;
use Shared\ApiGeneralBundle\Dto\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    private const AUTHORIZATION_HEADER_KEY = 'X-Authorization';
    private const ALGORITHM = 'HS256';
    private const LEEWAY = 60;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @var SecurityContextStorageInterface
     */
    private $securityContextStorage;

    /**
     * @var string
     */
    private $jwtKey;

    /**
     * @param DenormalizerInterface $denormalizer
     * @param SecurityContextStorageInterface $securityContextStorage
     * @param string $jwtKey
     */
    public function __construct(
        DenormalizerInterface $denormalizer,
        SecurityContextStorageInterface $securityContextStorage,
        string $jwtKey
    ) {
        $this->denormalizer = $denormalizer;
        $this->securityContextStorage = $securityContextStorage;
        $this->jwtKey = $jwtKey;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request)
    {
        return $request->headers->has(self::AUTHORIZATION_HEADER_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentials(Request $request)
    {
        return $request->headers->get(self::AUTHORIZATION_HEADER_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if ($credentials === null) {
            return null;
        }

        try {
            JWT::$leeway = self::LEEWAY;
            $decodedObject = JWT::decode($credentials, $this->jwtKey, [self::ALGORITHM]);
            $decodedArray = json_decode(json_encode($decodedObject), true);

            /** @var SecurityContext $securityContext */
            $securityContext = $this->denormalizer->denormalize($decodedArray['context'] ?? [], SecurityContext::class);

            $this->securityContextStorage->setSecurityContext($securityContext);

            return $this->transformSecurityContextToUser($securityContext);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritDoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param SecurityContext $securityContext
     *
     * @return User|null
     */
    private function transformSecurityContextToUser(SecurityContext $securityContext): ?User
    {
        if (empty($securityContext->getUserIdentifier())) {
            return null;
        }

        $user = new User();
        $user->setUuid($securityContext->getUserIdentifier());

        return $user;
    }
}
