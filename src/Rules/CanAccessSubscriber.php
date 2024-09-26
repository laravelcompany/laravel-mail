<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Rules;

use Illuminate\Contracts\Validation\Rule;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\Subscriber;

class CanAccessSubscriber implements Rule
{
    public function passes($attribute, $value): bool
    {
        $subscriber = Subscriber::find($value);

        if (! $subscriber) {
            return false;
        }

        return $subscriber->workspace_id == LaravelMail::currentWorkspaceId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
