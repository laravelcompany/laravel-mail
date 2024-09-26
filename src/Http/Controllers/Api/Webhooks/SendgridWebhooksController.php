<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Api\Webhooks;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use LaravelCompany\Mail\Events\Webhooks\SendgridWebhookReceived;
use LaravelCompany\Mail\Http\Controllers\Controller;

class SendgridWebhooksController extends Controller
{
    public function handle(): Response
    {
        $payload = collect(json_decode(request()->getContent(), true));

        Log::info('SendGrid webhook received');

        if ($payload->isEmpty()) {
            return response('OK (not processed');
        }

        foreach ($payload as $event) {
            event(new SendgridWebhookReceived($event));
        }

        return response('OK');
    }
}
