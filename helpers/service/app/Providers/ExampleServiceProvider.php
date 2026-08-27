<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ExampleClass
{
    //put any functions here
    public function test()
    {
        return 'test';
    }
}

class ExampleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('example', function () {
            return new ExampleClass;
        });
    }
}

use Illuminate\Support\Facades\Facade;

class Example extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'example';
    }
}
