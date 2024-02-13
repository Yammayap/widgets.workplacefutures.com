<?php

namespace Database\Factories;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpaceCalculatorInput>
 */
class SpaceCalculatorInputFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpaceCalculatorInput::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enquiry_id' => Enquiry::factory(),
            'workstyle' => Workstyle::PUBLIC_SECTOR,
            'total_people' => 250,
            'growth_percentage' => 10,
            'desk_percentage' => 15,
            'hybrid_working' => HybridWorking::TWO_DAYS,
            'mobility' => Mobility::LAPTOPS_ANYWHERE,
            'collaboration' => Collaboration::ALL_COLLABORATION,
        ];
    }
}
