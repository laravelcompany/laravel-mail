<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Routes;

use Illuminate\Routing\Router;
use LaravelCompany\Mail\Http\Controllers\WorkflowController;

class WebRoutes
{
    public function laravelMailPublicWebRoutes(): callable
    {
        return function () {
            $this->name('laravel-mail.')->namespace('\LaravelCompany\Mail\Http\Controllers')->group(static function (
                Router $appRouter
            ) {
                // Subscriptions
                $appRouter->name('subscriptions.')->namespace('Subscriptions')->prefix('subscriptions')->group(static function (
                    Router $subscriptionController
                ) {
                    $subscriptionController->get('unsubscribe/{messageHash}', 'SubscriptionsController@unsubscribe')
                        ->name('unsubscribe');
                    $subscriptionController->get(
                        'subscribe/{messageHash}',
                        'SubscriptionsController@subscribe'
                    )->name('subscribe');
                    $subscriptionController->put(
                        'subscriptions/{messageHash}',
                        'SubscriptionsController@update'
                    )->name('update');
                });

                // Webview.
                $appRouter->name('webview.')->prefix('webview')->namespace('Webview')->group(static function (
                    Router $webviewRouter
                ) {
                    $webviewRouter->get('{messageHash}', 'WebviewController@show')->name('show');
                });
            });
        };
    }

    public function laravelMailWebRoutes(): callable
    {
        return function () {
            $this->name('laravel-mail.')->namespace('\LaravelCompany\Mail\Http\Controllers')->group(static function (
                Router $appRouter
            ) {
                // Dashboard.
                $appRouter->get('/', 'DashboardController@index')->name('dashboard');

                // Campaigns.
                $appRouter->resource('campaigns', 'Campaigns\CampaignsController')->except(['show', 'destroy']);
                $appRouter->name('campaigns.')->prefix('campaigns')->namespace('Campaigns')->group(static function (
                    Router $campaignRouter
                ) {
                    $campaignRouter->get('sent', 'CampaignsController@sent')->name('sent');
                    $campaignRouter->get('{id}', 'CampaignsController@show')->name('show');
                    $campaignRouter->get('{id}/preview', 'CampaignsController@preview')->name('preview');
                    $campaignRouter->put('{id}/send', 'CampaignDispatchController@send')->name('send');
                    $campaignRouter->get('{id}/status', 'CampaignsController@status')->name('status');
                    $campaignRouter->post('{id}/test', 'CampaignTestController@handle')->name('test');

                    $campaignRouter->get(
                        '{id}/confirm-delete',
                        'CampaignDeleteController@confirm'
                    )->name('destroy.confirm');
                    $campaignRouter->delete('', 'CampaignDeleteController@destroy')->name('destroy');

                    $campaignRouter->get('{id}/duplicate', 'CampaignDuplicateController@duplicate')->name('duplicate');

                    $campaignRouter->get('{id}/confirm-cancel', 'CampaignCancellationController@confirm')->name('confirm-cancel');
                    $campaignRouter->post('{id}/cancel', 'CampaignCancellationController@cancel')->name('cancel');

                    $campaignRouter->get('{id}/report', 'CampaignReportsController@index')->name('reports.index');
                    $campaignRouter->get('{id}/report/recipients', 'CampaignReportsController@recipients')
                        ->name('reports.recipients');
                    $campaignRouter->get('{id}/report/opens', 'CampaignReportsController@opens')->name('reports.opens');
                    $campaignRouter->get(
                        '{id}/report/clicks',
                        'CampaignReportsController@clicks'
                    )->name('reports.clicks');
                    $campaignRouter->get('{id}/report/unsubscribes', 'CampaignReportsController@unsubscribes')
                        ->name('reports.unsubscribes');
                    $campaignRouter->get(
                        '{id}/report/bounces',
                        'CampaignReportsController@bounces'
                    )->name('reports.bounces');
                });

                // Messages.
                $appRouter->name('messages.')->prefix('messages')->group(static function (Router $messageRouter) {
                    $messageRouter->get('/', 'MessagesController@index')->name('index');
                    $messageRouter->get('draft', 'MessagesController@draft')->name('draft');
                    $messageRouter->get('{id}/show', 'MessagesController@show')->name('show');
                    $messageRouter->post('send', 'MessagesController@send')->name('send');
                    $messageRouter->delete('{id}/delete', 'MessagesController@delete')->name('delete');
                    $messageRouter->post('send-selected', 'MessagesController@sendSelected')->name('send-selected');
                });

                // Email Services.
                $appRouter->name('email_services.')->prefix('email-services')->namespace('EmailServices')->group(static function (
                    Router $servicesRouter
                ) {
                    $servicesRouter->get('/', 'EmailServicesController@index')->name('index');
                    $servicesRouter->get('create', 'EmailServicesController@create')->name('create');
                    $servicesRouter->get('type/{id}', 'EmailServicesController@emailServicesTypeAjax')->name('ajax');
                    $servicesRouter->post('/', 'EmailServicesController@store')->name('store');
                    $servicesRouter->get('{id}/edit', 'EmailServicesController@edit')->name('edit');
                    $servicesRouter->put('{id}', 'EmailServicesController@update')->name('update');
                    $servicesRouter->delete('{id}', 'EmailServicesController@delete')->name('delete');

                    $servicesRouter->get('{id}/test', 'TestEmailServiceController@create')->name('test.create');
                    $servicesRouter->post('{id}/test', 'TestEmailServiceController@store')->name('test.store');
                });

                // Tags.
                $appRouter->resource('tags', 'Tags\TagsController')->except(['show']);
                $appRouter->resource('templates', 'TemplatesController');
                $appRouter->resource('importer', 'ImporterController');
                $appRouter->resource('inbox', 'Inbox\InboxController');

                // Subscribers.
                $appRouter->name('subscribers.')->prefix('subscribers')->namespace('Subscribers')->group(static function (
                    Router $subscriberRouter
                ) {
                    $subscriberRouter->get('export', 'SubscribersController@export')->name('export');
                    $subscriberRouter->get('import', 'SubscribersImportController@show')->name('import');
                    $subscriberRouter->get('import-new', 'SubscribersImportController@showNew')->name('import-new');
                    $subscriberRouter->post('import', 'SubscribersImportController@store')->name('import.store');
                    $subscriberRouter->post('import-new', 'SubscribersImportController@storeNew')->name('import.storeNew');
                });
                $appRouter->resource('subscribers', 'Subscribers\SubscribersController');

                // Templates.
                $appRouter->resource('templates', 'TemplatesController')->except(['show']);

                // Workflows
                $appRouter->name('workflows.')->prefix('workflows')->namespace('\LaravelCompany\Workflows\Http\Controllers')->group(static function (Router $workflowRouter) {
                    $workflowRouter->get('/', [WorkflowController::class, 'index'])->name('index');
                    $workflowRouter->get('create', [WorkflowController::class, 'create'])->name('create');
                    $workflowRouter->post('store', [WorkflowController::class, 'store'])->name('store');
                    $workflowRouter->get('{workflow}', [WorkflowController::class, 'show'])->name('show');
                    $workflowRouter->get('{workflow}/edit', [WorkflowController::class, 'edit'])->name('edit');
                    $workflowRouter->get('{workflow}/delete', [WorkflowController::class, 'delete'])->name('delete');
                    $workflowRouter->post('{workflow}/update', [WorkflowController::class, 'update'])->name('update');

                    /** Diagram routes */
                    $workflowRouter->post('diagram/{workflow}/addTask', [WorkflowController::class, 'addTask'])->name('addTask');
                    $workflowRouter->post('diagram/{workflow}/addTrigger', [WorkflowController::class, 'addTrigger'])->name('addTrigger');
                    $workflowRouter->post('diagram/{workflow}/addConnection', [WorkflowController::class, 'addConnection'])->name('addConnection');
                    $workflowRouter->post('diagram/{workflow}/removeConnection', [WorkflowController::class, 'removeConnection'])->name('removeConnection');
                    $workflowRouter->post('diagram/{workflow}/removeTask', [WorkflowController::class, 'removeTask'])->name('removeTask');
                    $workflowRouter->post('diagram/{workflow}/updateNodePosition', [WorkflowController::class, 'updateNodePosition'])->name('updateNodePosition');

                    /** Settings routes */
                    $workflowRouter->post('settings/{workflow}/changeConditions', [WorkflowController::class, 'changeConditions'])->name('changeConditions');
                    $workflowRouter->post('settings/{workflow}/changeValues', [WorkflowController::class, 'changeValues'])->name('changeValues');
                    $workflowRouter->post('settings/{workflow}/getElementSettings', [WorkflowController::class, 'getElementSettings'])->name('getElementSettings');
                    $workflowRouter->post('settings/{workflow}/getElementConditions', [WorkflowController::class, 'getElementConditions'])->name('getElementConditions');
                    $workflowRouter->post('settings/{workflow}/loadResourceIntelligence', [WorkflowController::class, 'loadResourceIntelligence'])->name('loadResourceIntelligence');

                    /** Log routes */
                    $workflowRouter->post('logs/reRun/{workflow_log_id}', [WorkflowController::class, 'reRun'])->name('reRun');
                    $workflowRouter->post('logs/reRun/', [WorkflowController::class, 'reRun'])->name('reRunJSHelper');
                    $workflowRouter->post('logs/{workflow}/getLogs', [WorkflowController::class, 'getLogs'])->name('getLogs');

                    /** Triggers */
                    $workflowRouter->post('button_trigger/execute/{id}', [WorkflowController::class, 'triggerButton'])->name('triggers.button');
                });
            });
        };
    }
}
