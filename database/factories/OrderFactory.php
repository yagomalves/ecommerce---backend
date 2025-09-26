<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'client')->inRandomOrder()->first()->id ?? User::factory(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
            'total' => 0, // vai ser atualizado depois
        ];
    }
}
