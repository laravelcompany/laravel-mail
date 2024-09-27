<?php

declare(strict_types=1);

namespace LaravelCompany\Mail;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\Console\Commands\CampaignDispatchCommand;
use LaravelCompany\Mail\Providers\EventServiceProvider;
use LaravelCompany\Mail\Providers\FormServiceProvider;
use LaravelCompany\Mail\Providers\LaravelMailServiceProvider;
use LaravelCompany\Mail\Providers\ResolverProvider;
use LaravelCompany\Mail\Providers\RouteServiceProvider;

use LaravelCompany\Mail\Services\LaravelMail;

class MailBaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-mail.php'),
            ], 'laravel-mail-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-mail'),
            ], 'laravel-mail-views');

            $this->publishes([
                __DIR__.'/../resources/lang' => app()->langPath('vendor/laravel-mail'),
            ], 'laravel-mail-lang');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/laravel-mail'),
            ], 'laravel-mail-assets');

            $this->commands([
                CampaignDispatchCommand::class,
            ]);

            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command(CampaignDispatchCommand::class)->everyMinute()->withoutOverlapping();
            });
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-mail');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/laravel-mail'));
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-mail');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Providers.
        $this->app->register(EventServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ResolverProvider::class);
        $this->app->register(LaravelMailServiceProvider::class);



        // Facade.
        $this->app->bind('laravel-mail', static function (Application $app) {
            return $app->make(LaravelMail::class);
        });

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-mail');
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'workflows');
    }
}
