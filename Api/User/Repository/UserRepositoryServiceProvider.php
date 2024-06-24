<?php
namespace Api\User\Repository;
use Api\User\Repository\IUserRepository;
use Api\User\Repository\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class UserRepositoryServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        $this->app->bind(IUserRepository::class, function(Application $app){
            return new UserRepository();
        });
    }
}