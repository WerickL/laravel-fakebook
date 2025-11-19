<?php 
namespace Api\Like\Repository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LikeRepositoryServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        $this->app->bind(ILikeRepository::class, function(Application $app){
            return new LikeRepository();
        });
    }
}