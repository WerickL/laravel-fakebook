<?php
namespace Api\User\Model;

use Illuminate\Support\Facades\Hash;

class UserDto
{
    public function __construct(
    public $name = null, 
    public $email= null,
    public $password= null,
    public $username= null)
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