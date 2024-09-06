<?php

namespace Api\User\Repository;

use Api\User\Model\User;
use Api\User\Model\UserDto;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function create(UserDto $userData): User
    {
        return User::create($userData->toArray());
    }
    public function patch(User $user,UserDto $data): User
    {
        return $user->fill($data->toArray());
    }
}