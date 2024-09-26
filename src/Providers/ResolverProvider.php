<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\Services\ResolverService;

class ResolverProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('laravel-mail.resolver', function () {
            return new ResolverService();
        });
    }


}
