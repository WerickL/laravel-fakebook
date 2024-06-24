<?php
namespace Api\User\Model;
class UserDto
{
    public function __construct(
    public string $name, 
    public string $email,
    public string $password,
    public string $username)
    {
    }
}