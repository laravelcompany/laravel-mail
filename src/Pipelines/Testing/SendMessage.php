<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Pipelines\Testing;

use Illuminate\Http\Request;
use LaravelCompany\Mail\Events\MessageDispatchEvent;
use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Models\Message;
use LaravelCompany\Mail\Models\Subscriber;

class SendMessage
{
    public function handle(Request $request, $next)
    {
        $campaign = Campaign::find($request->campaign);

        $subscriber = Subscriber::where('email', $request->email)->first();

        $attributes = [
            'workspace_id' => $campaign->workspace_id,
            'subscriber_id' => $subscriber->id,
            'source_type' => Campaign::class,
            'source_id' => $campaign->id,
            'recipient_email' => $subscriber->email,
            'subject' => $campaign->subject,
            'from_name' => $campaign->from_name,
            'from_email' => $campaign->from_email,
            'queued_at' => null,
            'sent_at' => null,
        ];

        $message = new Message($attributes);
        $message->save();

        event(new MessageDispatchEvent($message));

        return $next($request);
    }
}
