<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelCompany\Mail\Models\Subscriber;

class SubscriberAddedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var Subscriber */
    public Subscriber $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
