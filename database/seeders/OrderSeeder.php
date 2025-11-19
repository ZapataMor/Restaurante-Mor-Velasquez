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
                'reservation_id' => 1,   // Tiene reserva
                'table_id'       => 1,
                'user_id'        => 2,   // Mesero
                'client_name'    => 'Carlos Mendoza',
                'client_document'=> '1023456789',
                'status'         => 'abierta',
                'payment_status' => 'pendiente',
                'total_amount'   => 0,
            ],
            [
                'reservation_id' => null, // Sin reserva (cliente directo)
                'table_id'       => 2,
                'user_id'        => 3,
                'client_name'    => 'Cliente sin reserva',
                'client_document'=> '9999999999',
                'status'         => 'en_proceso',
                'payment_status' => 'pendiente',
                'total_amount'   => 45.50,
            ],
            [
                'reservation_id' => 2, // Tiene reserva
                'table_id'       => 3,
                'user_id'        => 2,
                'client_name'    => 'María Torres',
                'client_document'=> '1087654321',
                'status'         => 'completada',
                'payment_status' => 'pagado',
                'total_amount'   => 72.90,
            ],
            [
                'reservation_id' => null,
                'table_id'       => 4,
                'user_id'        => 4,
                'client_name'    => 'Cliente cancelado',
                'client_document'=> '0000000000',
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
