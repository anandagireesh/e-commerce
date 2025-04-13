<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Order::factory()->count(100)->create()->each(function ($order) {
            $products = \App\Models\Product::inRandomOrder()->take(rand(1, 5))->get();

            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total' => $product->price * $quantity
                ]);
            }
        });
    }
}
