<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use LaravelCompany\Mail\Rules\CanAccessTag;

class SubscriberTagDestroyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tags' => ['array', 'required'],
            'tags.*' => ['integer', new CanAccessTag($this->user())]
        ];
    }
}
