<?php 
namespace Api\Post\Repository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class PostRepositoryServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        $this->app->bind(IPostRepository::class, function(Application $app){
            return new PostRepository();
        });
    }
}