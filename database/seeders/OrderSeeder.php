<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'reservation_id' => 1,   // Reserva existente
                'table_id'       => 1,
                'user_id'        => 2,   // Mesero
                'status'         => 'abierta',
                'payment_status' => 'pendiente',
                'total_amount'   => 0,
            ],
            [
                'reservation_id' => null, // Sin reserva (cliente llega directo)
                'table_id'       => 2,
                'user_id'        => 3,    // Otro mesero
                'status'         => 'en_proceso',
                'payment_status' => 'pendiente',
                'total_amount'   => 45.50,
            ],
            [
                'reservation_id' => 2,
                'table_id'       => 3,
                'user_id'        => 2,
                'status'         => 'completada',
                'payment_status' => 'pagado',
                'total_amount'   => 72.90,
            ],
            [
                'reservation_id' => null,
                'table_id'       => 4,
                'user_id'        => 4,
                'status'         => 'cancelada',
                'payment_status' => 'pendiente',
                'total_amount'   => 0,
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
