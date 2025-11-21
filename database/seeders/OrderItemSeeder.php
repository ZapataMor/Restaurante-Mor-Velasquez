<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        // $items = [
        //     // Ítems para la Orden 1 (abierta)
        //     [
        //         'order_id'  => 1,
        //         'product_id'=> 1, // Pizza Margherita
        //         'notes'     => 'Sin albahaca',
        //         'quantity'  => 1,
        //         'price'     => 12.99,
        //         'total'     => 12.99,
        //         'status'    => 'pendiente',
        //     ],
        //     [
        //         'order_id'  => 1,
        //         'product_id'=> 4, // Hamburguesa Clásica
        //         'notes'     => 'Sin tomate',
        //         'quantity'  => 2,
        //         'price'     => 9.99,
        //         'total'     => 19.98,
        //         'status'    => 'preparando',
        //     ],

        //     // Ítems para la Orden 2 (en proceso)
        //     [
        //         'order_id'  => 2,
        //         'product_id'=> 2, // Pizza Pepperoni
        //         'notes'     => null,
        //         'quantity'  => 1,
        //         'price'     => 14.99,
        //         'total'     => 14.99,
        //         'status'    => 'listo',
        //     ],
        //     [
        //         'order_id'  => 2,
        //         'product_id'=> 10, // Brownie
        //         'notes'     => 'Sin nueces',
        //         'quantity'  => 3,
        //         'price'     => 5.99,
        //         'total'     => 17.97,
        //         'status'    => 'listo',
        //     ],

        //     // Ítems para la Orden 3 (completada)
        //     [
        //         'order_id'  => 3,
        //         'product_id'=> 3, // Spaghetti
        //         'notes'     => null,
        //         'quantity'  => 2,
        //         'price'     => 10.99,
        //         'total'     => 21.98,
        //         'status'    => 'listo',
        //     ],
        //     [
        //         'order_id'  => 3,
        //         'product_id'=> 5, // Ensalada César
        //         'notes'     => 'Sin pollo',
        //         'quantity'  => 1,
        //         'price'     => 8.99,
        //         'total'     => 8.99,
        //         'status'    => 'listo',
        //     ],

        //     // Ítems para la Orden 4 (cancelada)
        //     [
        //         'order_id'  => 4,
        //         'product_id'=> 8, // Lasagna
        //         'notes'     => 'Extra queso',
        //         'quantity'  => 1,
        //         'price'     => 13.99,
        //         'total'     => 13.99,
        //         'status'    => 'preparando',
        //     ],
        // ];

        // foreach ($items as $item) {
        //     OrderItem::create($item);
        // }
    }
}
