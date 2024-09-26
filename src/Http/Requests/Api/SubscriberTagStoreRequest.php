<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use LaravelCompany\Mail\Rules\CanAccessTag;

class SubscriberTagStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tags' => ['array', 'required'],
            'tags.*' => ['integer', new CanAccessTag()]
        ];
    }
}
