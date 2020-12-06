<?php

namespace App\Api\Reader;

use App\Repository\UserRepository;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceNotFoundException;
use Shared\UserDto\Dto\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserReader implements UserReaderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userEncoder;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $userEncoder)
    {
        $this->userRepository = $userRepository;
        $this->userEncoder = $userEncoder;
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(string $email, ?string $password): User
    {
        $userEntity = $this->userRepository->findOneBy(['email' => $email]);

        if ($userEntity === null || $password !== null
            && $this->userEncoder->isPasswordValid($userEntity, $password) === false) {
            throw new ResourceNotFoundException();
        }

        $user = new User();
        $user->setUuid($userEntity->getUuid());
        $user->setEmail($userEntity->getEmail());

        return $user;
    }
}
