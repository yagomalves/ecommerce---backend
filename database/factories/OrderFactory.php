<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            //user_id no seeder
            'status' => $this->faker->randomElement([
                'pending',
                'paid',
                'shipped',
                'delivered',
                'cancelled' // ✅ apenas valores permitidos pelo ENUM
            ]),
            'total' => 0, // vai ser atualizado depois
            'payment_method' => $this->faker->randomElement(['credit_card', 'pix', 'boleto', 'paypal']),
        ];
    }
}
