<?php

namespace Database\Factories;

use App\Models\MagicLink;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MagicLink>
 */
class MagicLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MagicLink::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ipAddress = $this->faker->ipv4;

        return [
            'user_id' => User::factory(),
            'requested_at' => CarbonImmutable::now()->subMinutes(5),
            'expires_at' => CarbonImmutable::now()->addMinutes(5),
            'authenticated_at' => null,
            'ip_requested_from' => $ipAddress,
            'ip_authenticated_from' => null,
            'intended_url' => null,
        ];
    }

    /**
     * @return static
     */
    public function expired(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'requested_at' => CarbonImmutable::now()->subMinutes(25),
                'expires_at' => CarbonImmutable::now()->subMinutes(15),
            ];
        });
    }

    /**
     * @return static
     */
    public function authenticated(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'requested_at' => CarbonImmutable::now()->subMinutes(25),
                'expires_at' => CarbonImmutable::now()->subMinutes(15),
                'authenticated_at' => CarbonImmutable::now()->subMinutes(20),
            ];
        });
    }
}
