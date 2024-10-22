<?php

namespace LaravelCompany\Mail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelCompany\Mail\Facades\LaravelMail;

class TemplateUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('templates')
                    ->where('workspace_id', LaravelMail::currentWorkspaceId())
                    ->ignore($this->template),
            ],
            'content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('The template name must be unique.'),
        ];
    }
}
