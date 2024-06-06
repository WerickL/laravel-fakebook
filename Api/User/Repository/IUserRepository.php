<?php

namespace Api\User\Repository;

use Api\User\Model\User;
use UserDto;

interface IUserRepository
{
    public function create(UserDto $userDto): User;
}