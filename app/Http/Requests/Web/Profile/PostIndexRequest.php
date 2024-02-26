<?php

namespace App\Http\Requests\Web\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Propaganistas\LaravelPhone\Rules\Phone;

class PostIndexRequest extends FormRequest
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
            'phone' => ['nullable', (new Phone())->international()->country('GB')],
            'marketing_opt_in' => ['nullable', 'boolean'],
        ];
    }
}
