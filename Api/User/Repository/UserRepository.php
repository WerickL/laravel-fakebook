<?php

namespace Api\User\Repository;

use Api\User\Model\User;

class UserRepository implements IUserRepository
{
    public function create($userData): User
    {
        return User::create($userData);
    }
}