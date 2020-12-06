<?php

namespace Shared\ApiClientSecurityBundle\Provider;

use Firebase\JWT\JWT;
use Shared\ApiGeneralBundle\Dto\SecurityContext;
use Shared\ApiGeneralBundle\Storage\SecurityContextStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AuthorizationHeaderProvider implements AuthorizationHeaderProviderInterface
{
    private const AUTHORIZATION_HEADER_KEY = 'X-Authorization';
    private const ALGORITHM = 'HS256';

    /**
     * @var string
     */
    private $jwtKey;

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @var SecurityContextStorageInterface
     */
    private $securityContextStorage;

    /**
     * @var Security
     */
    private $security;

    /**
     * @param NormalizerInterface $normalizer
     * @param SecurityContextStorageInterface $securityContextStorage
     * @param Security $security
     * @param string $jwtKey
     */
    public function __construct(
        NormalizerInterface $normalizer,
        SecurityContextStorageInterface $securityContextStorage,
        Security $security,
        string $jwtKey
    ) {
        $this->normalizer = $normalizer;
        $this->securityContextStorage = $securityContextStorage;
        $this->security = $security;
        $this->jwtKey = $jwtKey;
    }

    /**
     * {@inheritDoc}
     */
    public function buildHeadersMap(): array
    {
        return [self::AUTHORIZATION_HEADER_KEY => $this->buildJwtToken()];
    }

    /**
     * @return string
     */
    private function buildJwtToken(): string
    {
        $payload = [
            'iat' => time(),
            'context' => $this->normalizer->normalize($this->buildSecurityContext()),
        ];

        return JWT::encode($payload, $this->jwtKey, self::ALGORITHM);
    }

    /**
     * @return SecurityContext
     */
    private function buildSecurityContext(): SecurityContext
    {
        $securityContext = $this->securityContextStorage->getSecurityContext();

        if (isset($securityContext)) {
            return $securityContext;
        }

        $securityContext = new SecurityContext();
        $user = $this->security->getUser();

        if ($user !== null) {
            $securityContext->setAnonymous(false);
            $securityContext->setUserIdentifier($user->getUsername());
        }

        return $securityContext;
    }
}
