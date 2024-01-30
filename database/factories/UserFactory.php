<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'       => $this->faker->firstName,
            'last_name'        => $this->faker->lastName,
            'email'            => $this->faker->safeEmail,
            'company_name'     => null,
            'phone'            => null,
            'marketing_opt_in' => false,
        ];
    }

    /**
     * @return static
     */
    public function allFields(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'company_name' => $this->faker->company,
                'phone' => new PhoneNumber('07700000000', 'GB'),
            ];
        });
    }

    /**
     * @return static
     */
    public function acceptedMarketing(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'marketing_opt_in' => true,
            ];
        });
    }
}
