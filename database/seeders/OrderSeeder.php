<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Table;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $mesero = User::where('role', 'mesero')->first();
        $table = Table::inRandomOrder()->first();

        $order = Order::create([
            'table_id' => $table->id,
            'user_id' => $mesero->id,
            'status' => 'en_preparación',
        ]);

        $products = Product::inRandomOrder()->take(2)->get();

        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
                'price' => $product->price,
                'subtotal' => $product->price * rand(1, 3),
            ]);
        }
    }
}
