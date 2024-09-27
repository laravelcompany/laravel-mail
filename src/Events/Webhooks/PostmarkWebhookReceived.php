<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Events\Webhooks;

class PostmarkWebhookReceived
{
    /** @var array */
    public $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
