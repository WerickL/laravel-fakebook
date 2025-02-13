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
    public function find(string|int $id): User{
        return User::where("id", (int) $id)->first();
    }
    public function follow(User $user, User $followed): bool
    {
        try {
            $user->following()->attach($followed);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}