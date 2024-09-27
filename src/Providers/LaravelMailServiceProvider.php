<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\Interfaces\QuotaServiceInterface;
use LaravelCompany\Mail\Repositories\Campaigns\CampaignTenantRepositoryInterface;
use LaravelCompany\Mail\Repositories\Campaigns\MySqlCampaignTenantRepository;
use LaravelCompany\Mail\Repositories\Campaigns\PostgresCampaignTenantRepository;
use LaravelCompany\Mail\Repositories\Messages\MessageTenantRepositoryInterface;
use LaravelCompany\Mail\Repositories\Messages\MySqlMessageTenantRepository;
use LaravelCompany\Mail\Repositories\Messages\PostgresMessageTenantRepository;
use LaravelCompany\Mail\Repositories\Subscribers\MySqlSubscriberTenantRepository;
use LaravelCompany\Mail\Repositories\Subscribers\PostgresSubscriberTenantRepository;
use LaravelCompany\Mail\Repositories\Subscribers\SubscriberTenantRepositoryInterface;
use LaravelCompany\Mail\Services\Helper;
use LaravelCompany\Mail\Services\QuotaService;
use LaravelCompany\Mail\Traits\ResolvesDatabaseDriver;

class LaravelMailServiceProvider extends ServiceProvider
{
    use ResolvesDatabaseDriver;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Campaign repository.
        $this->app->bind(CampaignTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresCampaignTenantRepository::class);
            }

            return $app->make(MySqlCampaignTenantRepository::class);
        });

        // Message repository.
        $this->app->bind(MessageTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresMessageTenantRepository::class);
            }

            return $app->make(MySqlMessageTenantRepository::class);
        });

        // Subscriber repository.
        $this->app->bind(SubscriberTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresSubscriberTenantRepository::class);
            }

            return $app->make(MySqlSubscriberTenantRepository::class);
        });

        $this->app->bind(QuotaServiceInterface::class, QuotaService::class);

        $this->app->singleton('laravel-mail.helper', function () {
            return new Helper();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
