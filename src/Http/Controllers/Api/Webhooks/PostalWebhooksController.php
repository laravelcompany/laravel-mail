<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Api\Webhooks;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use LaravelCompany\Mail\Events\Webhooks\PostalWebhookReceived;
use LaravelCompany\Mail\Http\Controllers\Controller;

class PostalWebhooksController extends Controller
{

    // TODO(david): This is not working yet.
    public function handle(): Response
    {
        $payload = json_decode(request()->getContent(), true);

        Log::info('Postal webhook received');

        event(new PostalWebhookReceived($payload));


        return response('OK');
    }
}
