<?php

namespace Database\Factories;

use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enquiry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'tenant' => Tenant::WFG,
            'widget' => Widget::SPACE_CALCULATOR,
            'message' => null,
            'can_contact' => false,
        ];
    }

    /**
     * @return static
     */
    public function allFields(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'user_id' => User::factory()->create()->id,
                'message' => $this->faker->text,
            ];
        });
    }

    /**
     * @return static
     */
    public function contactable(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'can_contact' => true,
            ];
        });
    }

    /**
     * @return static
     */
    public function filledMessage(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'message' => $this->faker->text,
            ];
        });
    }

    /**
     * @return static
     */
    public function hasUser(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'user_id' => User::factory()->create()->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function tenantAmbit(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'tenant' => Tenant::AMBIT,
            ];
        });
    }

    /**
     * @return static
     */
    public function tenantModus(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'tenant' => Tenant::MODUS,
            ];
        });
    }

    /**
     * @return static
     */
    public function tenantPlatfform(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'tenant' => Tenant::PLATFFORM,
            ];
        });
    }

    /**
     * @return static
     */
    public function tenantTwo(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'tenant' => Tenant::TWO,
            ];
        });
    }
}
