<?php

namespace Api\User\Repository;

use Api\User\Model\User;
use Api\User\Model\UserDto;

interface IUserRepository
{
    public function create(UserDto $userDto): User;
    public function patch(User $user,UserDto $data): User;
    public function find(string|int $id): User;
    public function follow(User $user, User $followed): bool;
}