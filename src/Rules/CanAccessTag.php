<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Rules;

use Illuminate\Contracts\Validation\Rule;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\Tag;

class CanAccessTag implements Rule
{
    public function passes($attribute, $value): bool
    {
        $tag = Tag::find($value);

        if (! $tag) {
            return false;
        }

        return $tag->workspace_id == LaravelMail::currentWorkspaceId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Tag ID :input does not exist.';
    }
}
