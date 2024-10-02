<?php

namespace Database\Seeders;

use App\Models\Blog\BlogPost;
use App\Models\Category\Category;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Product::factory(10)->create();
        Category::factory(10)->create();
        OrderItem::factory(10)->create();
        Order::factory(10)->create();
        BlogPost::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
