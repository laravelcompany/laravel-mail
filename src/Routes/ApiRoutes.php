<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Routes;

use Illuminate\Routing\Router;

class ApiRoutes
{
    public function laravelMailApiRoutes(): callable
    {
        return function () {
            $this->name('laravel-mail.api.')->prefix('v1')->namespace('\LaravelCompany\Mail\Http\Controllers\Api')->group(static function (Router $apiRouter) {
                $apiRouter->apiResource('campaigns', 'CampaignsController');
                $apiRouter->post('campaigns/{id}/send', 'CampaignDispatchController@send')->name('campaigns.send');
                $apiRouter->apiResource('subscribers', 'SubscribersController');
                $apiRouter->apiResource('tags', 'TagsController');

                $apiRouter->apiResource('subscribers.tags', 'SubscriberTagsController')
                    ->except(['show', 'update', 'destroy']);
                $apiRouter->put('subscribers/{subscriber}/tags', 'SubscriberTagsController@update')
                    ->name('subscribers.tags.update');
                $apiRouter->delete('subscribers/{subscriber}/tags', 'SubscriberTagsController@destroy')
                    ->name('subscribers.tags.destroy');

                $apiRouter->apiResource('tags.subscribers', 'TagSubscribersController')
                    ->except(['show', 'update', 'destroy']);
                $apiRouter->put('tags/{tag}/subscribers', 'TagSubscribersController@update')
                    ->name('tags.subscribers.update');
                $apiRouter->delete('tags/{tag}/subscribers', 'TagSubscribersController@destroy')
                    ->name('tags.subscribers.destroy');

                $apiRouter->apiResource('templates', 'TemplatesController');
            });
        };
    }

    public function laravelMailPublicApiRoutes(): callable
    {
        return function () {
            $this->name('laravel-mail.api.webhooks.')->prefix('v1/webhooks')->namespace('\LaravelCompany\Mail\Http\Controllers\Api\Webhooks')->group(static function (Router $webhookRouter) {
                $webhookRouter->post('aws', 'SesWebhooksController@handle')->name('aws');
                $webhookRouter->post('mailgun', 'MailgunWebhooksController@handle')->name('mailgun');
                $webhookRouter->post('postmark', 'PostmarkWebhooksController@handle')->name('postmark');
                $webhookRouter->post('sendgrid', 'SendgridWebhooksController@handle')->name('sendgrid');
                $webhookRouter->post('mailjet', 'MailjetWebhooksController@handle')->name('mailjet');
                $webhookRouter->post('postal', 'PostalWebhooksController@handle')->name('postal');
            });

            $this->get('v1/ping', '\LaravelCompany\Mail\Http\Controllers\Api\PingController@index');
        };
    }
}
