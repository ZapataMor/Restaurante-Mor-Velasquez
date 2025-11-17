<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = [
            [
                'client_name'      => 'Juan Pérez',
                'client_contact'   => '3001234567',
                'cliente_document' => '1095823412',
                'people_count'     => 4,
                'reservation_time' => Carbon::now()->addDay()->setTime(19, 30),
                'status'           => 'pendiente',
                'user_id'          => null,
                'notes'            => 'Prefiere mesa cerca a la ventana.',
            ],
            [
                'client_name'      => 'María Gómez',
                'client_contact'   => '3019876543',
                'cliente_document' => '1029384756',
                'people_count'     => 2,
                'reservation_time' => Carbon::now()->addDays(2)->setTime(18, 00),
                'status'           => 'confirmada',
                'user_id'          => 1,
                'notes'            => 'Celebración de aniversario.',
            ],
            [
                'client_name'      => 'Carlos Ramírez',
                'client_contact'   => '3025558899',
                'cliente_document' => '1005839201',
                'people_count'     => 6,
                'reservation_time' => Carbon::now()->addHours(5),
                'status'           => 'pendiente',
                'user_id'          => null,
                'notes'            => null,
            ],
            [
                'client_name'      => 'Laura Martínez',
                'client_contact'   => '3124447788',
                'cliente_document' => '1122334455',
                'people_count'     => 3,
                'reservation_time' => Carbon::now()->subDay()->setTime(20, 15),
                'status'           => 'cancelada',
                'user_id'          => 2,
                'notes'            => 'Cancelada por el cliente.',
            ],
            [
                'client_name'      => 'Pedro Torres',
                'client_contact'   => '3157776699',
                'cliente_document' => '1199223344',
                'people_count'     => 5,
                'reservation_time' => Carbon::now()->addDays(3)->setTime(21, 00),
                'status'           => 'confirmada',
                'user_id'          => 3,
                'notes'            => 'Mesa amplia, clientes frecuentes.',
            ],
        ];

        foreach ($reservations as $data) {
            Reservation::create($data);
        }
    }
}
