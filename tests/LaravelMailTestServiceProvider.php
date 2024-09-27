<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\Facades\LaravelMail;

class LaravelMailTestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        LaravelMail::setCurrentWorkspaceIdResolver(function () {
            return 1;
        });

        Route::group(['prefix' => 'laravel-mail'], function () {
            LaravelMail::webRoutes();
            LaravelMail::publicWebRoutes();
            LaravelMail::apiRoutes();
            LaravelMail::publicApiRoutes();
        });
    }
}
