<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $tables = Table::all();
        $waiters = User::where('role', 'mesero')->get();

        $names = ['Juan Pérez', 'María Gómez', 'Carlos Ramírez', 'Ana Torres', 'Miguel Sánchez', 'Laura Martínez', 'Pedro Torres', 'Sofía López', 'Diego Fernández', 'Camila Rojas'];

        $reservationCount = 10; // Solo 10 reservas
        $usedTables = [];

        for ($i = 0; $i < $reservationCount; $i++) {
            // Elegir mesa disponible al azar
            $availableTables = $tables->whereNotIn('id', $usedTables);
            if ($availableTables->isEmpty()) break;

            $table = $availableTables->random();
            $usedTables[] = $table->id;

            $waiter = $waiters->random();

            // Distribuir tiempos
            if ($i < 3) {
                // 3 reservas empezaron hace 15 minutos
                $reservationTime = Carbon::now()->subMinutes(15);
            } elseif ($i < 6) {
                // 3 reservas comienzan 30 minutos después
                $reservationTime = Carbon::now()->addMinutes(30);
            } else {
                // Las restantes más tarde en el día (horarios aleatorios 18:00-21:00)
                $hour = rand(18, 21);
                $minute = [0, 15, 30, 45][rand(0, 3)];
                $reservationTime = Carbon::now()->setTime($hour, $minute);
            }

            Reservation::create([
                'client_name'      => $names[$i % count($names)],
                'client_contact'   => '300' . rand(1000000, 9999999),
                'client_document'  => rand(1000000000, 1999999999),
                'people_count'     => rand(1, $table->capacity),
                'reservation_time' => $reservationTime,
                'status'           => 'confirmada',
                'table_id'         => $table->id,
                'user_id'          => $waiter->id,
                'notes'            => 'Reserva generada automáticamente para el mapa.',
            ]);
        }

        // Algunas mesas quedan libres para no saturar
    }
}
