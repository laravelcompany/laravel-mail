<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use LaravelCompany\Mail\Rules\CanAccessSubscriber;

class TagSubscriberDestroyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subscribers' => ['array', 'required'],
            'subscribers.*' => ['integer', new CanAccessSubscriber()]
        ];
    }
}
