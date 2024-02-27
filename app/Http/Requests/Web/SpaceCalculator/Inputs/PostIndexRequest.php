<?php

namespace App\Http\Requests\Web\SpaceCalculator\Inputs;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PostIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|Enum>>
     */
    public function rules(): array
    {
        $rules = [
            'workstyle' => ['required', Rule::enum(Workstyle::class)],
            'hybrid_working' => ['required', Rule::enum(HybridWorking::class)],
            'mobility' => ['required', Rule::enum(Mobility::class)],
            'collaboration' => ['required', Rule::enum(Collaboration::class)],
            'total_people' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'growth_percentage' => ['required', 'integer', 'min:0', 'max:2147483647'],
            'desk_percentage' => ['required', 'integer', 'min:0', 'max:2147483647'],
        ];

        /* todo: discuss - is there a better way to do this? I know you can do the following URL but that doesn't seem
        appropriate? I want to merge these rules in with the rules above only if the user is logged in
        https://laravel.com/docs/10.x/validation#performing-additional-validation-on-form-requests

        Or perhaps they could be included above anyway because they are nullable?
         */

        if (Auth::check()) {
            $rules['message'] = ['nullable', 'string', 'max:65535'];
            $rules['can_contact'] = ['nullable', 'boolean'];
        }

        return $rules;
    }
}
