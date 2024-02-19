<?php

namespace App\Http\Requests\Web\SpaceCalculator\Summary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PostFullDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|Enum>>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20'],

            // todo: discuss - Should the message rule have a max of 65535?
            // This link - https://shorturl.at/pqLRV - says we don't have to?
            'message' => ['nullable', 'string'],

            'marketing_opt_in' => ['nullable', 'boolean'],
            'can_contact' => ['nullable', 'boolean'],
        ];
    }
}
