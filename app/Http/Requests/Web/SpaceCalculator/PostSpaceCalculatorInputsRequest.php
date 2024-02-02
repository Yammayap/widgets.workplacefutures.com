<?php

namespace App\Http\Requests\Web\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PostSpaceCalculatorInputsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|Enum>>
     */
    public function rules(): array
    {
        return [
            'workstyle' => ['required', Rule::enum(Workstyle::class)],
            'hybrid_working' => ['required', Rule::enum(HybridWorking::class)],
            'mobility' => ['required', Rule::enum(Mobility::class)],
            'collaboration' => ['required', Rule::enum(Collaboration::class)],
            'total_people' => ['required', 'numeric', 'min:1'],
            'growth_percentage' => ['required', 'numeric', 'min:0'],
            'desk_percentage' => ['required', 'numeric', 'min:0'],
        ];
    }
}
