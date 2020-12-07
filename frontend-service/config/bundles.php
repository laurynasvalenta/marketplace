<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Shared\ApiClientSecurityBundle\ApiClientSecurityBundle::class => ['all' => true],
    Shared\ApiGeneralBundle\ApiGeneralBundle::class => ['all' => true],
    Shared\AuthClientBundle\AuthClientBundle::class => ['all' => true],
    Shared\ProductClientBundle\ProductClientBundle::class => ['all' => true],
    Shared\OrderClientBundle\OrderClientBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
];
