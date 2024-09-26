<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\Routes\ApiRoutes;
use LaravelCompany\Mail\Routes\WebRoutes;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::mixin(new ApiRoutes());
        Route::mixin(new WebRoutes());
    }
}
