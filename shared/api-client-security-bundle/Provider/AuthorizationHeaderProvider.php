<?php

namespace Shared\ApiClientSecurityBundle\Provider;

use Firebase\JWT\JWT;
use Shared\ApiGeneralBundle\Dto\SecurityContext;
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
     * @param NormalizerInterface $normalizer
     * @param string $jwtKey
     */
    public function __construct(NormalizerInterface $normalizer, string $jwtKey)
    {
        $this->normalizer = $normalizer;
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
        return new SecurityContext();
    }
}
