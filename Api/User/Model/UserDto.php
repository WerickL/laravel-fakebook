<?php
namespace Api\User\Model;

use Illuminate\Support\Facades\Hash;

class UserDto
{
    public function __construct(
    public string $name = null, 
    public string $email = null,
    public string $password = null,
    public string $username = null)
    {
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            "username" => $this->username
        ];
    }
}