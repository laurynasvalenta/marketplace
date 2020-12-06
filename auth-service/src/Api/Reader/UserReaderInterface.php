<?php

namespace App\Api\Reader;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\UserDto\Dto\User;

interface UserReaderInterface
{
    /**
     * @param string $email
     * @param string|null $password
     *
     * @return User
     *
     * @throws ResourceExceptionInterface
     */
    public function findBy(string $email, ?string $password): User;
}
