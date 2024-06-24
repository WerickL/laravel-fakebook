<?php

namespace Api\User\Repository;

use Api\User\Model\User;
use Api\User\Model\UserDto;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function create(UserDto $userData): User
    {
        return User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => Hash::make($userData->password),
            "username" => $userData->username
        ]);
    }
}