<?php

use App\Providers\AuthServiceProvider;

return [
    Api\Post\Repository\PostRepositoryServiceProvider::class,
    Api\User\Repository\UserRepositoryServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    AuthServiceProvider::class
];
