<?php

namespace Database\Factories\Order;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // Tworzy nowe zamówienie
            'product_id' => Product::factory(), // Tworzy nowy produkt
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
