<?php

namespace App\Api\Writer;

use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\UserDto\Dto\User;

interface UserWriterInterface
{
    /**
     * @param User $user
     *
     * @return User
     *
     * @throws ResourceExceptionInterface
     */
    public function create(User $user): User;
}
