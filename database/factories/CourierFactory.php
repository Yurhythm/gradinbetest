<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => strtoupper($this->faker->unique()->bothify('KR###')),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'sim_number' => strtoupper($this->faker->unique()->bothify('SIM#########')),
            'address' => $this->faker->address(),
            'level' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
