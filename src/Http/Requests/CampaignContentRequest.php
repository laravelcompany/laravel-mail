<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required'],
        ];
    }
}
