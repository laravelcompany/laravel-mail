<?php

namespace LaravelCompany\Mail\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelCompany\Mail\Events\MessageDispatchEvent;
use LaravelCompany\Mail\Events\SubscriberAddedEvent;
use LaravelCompany\Mail\Events\Webhooks\MailgunWebhookReceived;
use LaravelCompany\Mail\Events\Webhooks\MailjetWebhookReceived;
use LaravelCompany\Mail\Events\Webhooks\PostalWebhookReceived;
use LaravelCompany\Mail\Events\Webhooks\PostmarkWebhookReceived;
use LaravelCompany\Mail\Events\Webhooks\SendgridWebhookReceived;
use LaravelCompany\Mail\Events\Webhooks\SesWebhookReceived;
use LaravelCompany\Mail\Listeners\MessageDispatchHandler;
use LaravelCompany\Mail\Listeners\Webhooks\HandleMailgunWebhook;
use LaravelCompany\Mail\Listeners\Webhooks\HandleMailjetWebhook;
use LaravelCompany\Mail\Listeners\Webhooks\HandlePostalWebhook;
use LaravelCompany\Mail\Listeners\Webhooks\HandlePostmarkWebhook;
use LaravelCompany\Mail\Listeners\Webhooks\HandleSendgridWebhook;
use LaravelCompany\Mail\Listeners\Webhooks\HandleSesWebhook;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MailgunWebhookReceived::class => [
            HandleMailgunWebhook::class,
        ],
        MessageDispatchEvent::class => [
            MessageDispatchHandler::class,
        ],
        PostmarkWebhookReceived::class => [
            HandlePostmarkWebhook::class,
        ],
        SendgridWebhookReceived::class => [
            HandleSendgridWebhook::class,
        ],
        SesWebhookReceived::class => [
            HandleSesWebhook::class
        ],
        MailjetWebhookReceived::class => [
            HandleMailjetWebhook::class
        ],
        PostalWebhookReceived::class => [
            HandlePostalWebhook::class
        ],
        SubscriberAddedEvent::class => [
            // ...
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
