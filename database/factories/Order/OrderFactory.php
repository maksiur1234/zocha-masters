<?php

namespace Database\Factories\Order;

use App\Models\Order\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'total_price' => $this->faker->numberBetween(1000, 10000),
            'address_id' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
