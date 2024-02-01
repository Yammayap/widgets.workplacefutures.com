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
            'workstyle' => $this->faker->randomElement(Workstyle::cases())->value,
            'total_people' => $this->faker->numberBetween(10, 20),
            'growth_percentage' => $this->faker->numberBetween(0, 100),
            'desk_percentage' => $this->faker->numberBetween(0, 100),
            'hybrid_working' => $this->faker->randomElement(HybridWorking::cases())->value,
            'mobility' => $this->faker->randomElement(Mobility::cases())->value,
            'collaboration' => $this->faker->randomElement(Collaboration::cases())->value,
        ];
    }
}
