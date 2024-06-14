<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        ProductType::factory()->create([
            'name' => 'Type 1',
            'production_speed' => 715,
        ]);
        ProductType::factory()->create([
            'name' => 'Type 2',
            'production_speed' => 770,
        ]);
        ProductType::factory()->create([
            'name' => 'Type 3',
            'production_speed' => 1000,
        ]);

        $products = [
            ['Product A', 1],
            ['Product B', 1],
            ['Product C', 2],
            ['Product D', 3],
            ['Product E', 3],
            ['Product F', 1],
        ];

        foreach ($products as $product) {
            Product::factory()->create([
                'name' => $product[0],
                'type_id' => $product[1],
            ]);
        }

        $need_by = Carbon::now()->addDay();

        Order::factory()->create([
            'customer_id' => 1,
            'need_by' => $need_by->format('Y-m-d'),
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 1,
            'amount' => rand(50, 2000)
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 2,
            'amount' => rand(50, 2000)
        ]);

        Order::factory()->create([
            'customer_id' => 1,
            'need_by' => $need_by->format('Y-m-d'),
        ]);

        OrderItem::create([
            'order_id' => 2,
            'product_id' => 1,
            'amount' => rand(50, 2000)
        ]);

        OrderItem::create([
            'order_id' => 2,
            'product_id' => 2,
            'amount' => rand(50, 2000)
        ]);

        Order::factory()->create([
            'customer_id' => 1,
            'need_by' => $need_by->format('Y-m-d'),
        ]);

        OrderItem::create([
            'order_id' => 3,
            'product_id' => 5,
            'amount' => rand(50, 2000)
        ]);
    }
}
