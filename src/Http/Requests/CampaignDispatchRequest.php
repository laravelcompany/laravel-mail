<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Repositories\TagTenantRepository;

class CampaignDispatchRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var TagTenantRepository $tags */
        $tags = app(TagTenantRepository::class)->pluck(
            LaravelMail::currentWorkspaceId(),
            'id'
        );

        return [
            'tags' => [
                'required_unless:recipients,send_to_all',
                'array',
                Rule::in($tags),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tags.required_unless' => __('At least one tag must be selected'),
            'tags.in' => __('One or more of the tags is invalid.'),
        ];
    }
}
