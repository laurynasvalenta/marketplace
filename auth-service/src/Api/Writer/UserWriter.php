<?php

namespace App\Api\Writer;

use App\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Shared\ApiGeneralBundle\Exception\Resource\BadRequestResourceException;
use Shared\UserDto\Dto\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class UserWriter implements UserWriterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritDoc}
     */
    public function create(User $user): User
    {
        $userEntity = new UserEntity();
        $userEntity->setEmail($user->getEmail());
        $userEntity->setPassword($this->passwordEncoder->encodePassword($userEntity, $user->getPassword()));

        try {
            $this->entityManager->persist($userEntity);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new BadRequestResourceException();
        }

        $user->setUuid($userEntity->getUuid());

        return $user;
    }
}
