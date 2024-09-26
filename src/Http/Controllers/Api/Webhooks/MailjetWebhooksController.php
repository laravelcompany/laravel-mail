<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Api\Webhooks;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use LaravelCompany\Mail\Events\Webhooks\MailjetWebhookReceived;
use LaravelCompany\Mail\Http\Controllers\Controller;

class MailjetWebhooksController extends Controller
{
    public function handle(): Response
    {
        /** @var array $payload */
        $payload = json_decode(request()->getContent(), true);

        Log::info('Mailjet webhook received', $payload);

        event(new MailjetWebhookReceived($payload));

        return response('OK');
    }
}
