<?php 
namespace Api\File\Repository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FileRepositoryServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        $this->app->bind(IFileRepository::class, function(Application $app){
            return new FileRepository();
        });
    }
}