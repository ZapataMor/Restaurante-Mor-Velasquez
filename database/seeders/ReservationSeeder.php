<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $mesero = User::where('role', 'mesero')->inRandomOrder()->first();

        if (!$mesero || Table::count() === 0) {
            $this->command->warn('⚠️ No hay meseros o mesas disponibles. No se generaron reservas.');
            return;
        }

        // --- Reservas para Juan Pérez ---
        $juanReservations = [
            [
                'client_name' => 'Juan Pérez',
                'client_contact' => '3001234567',
                'cliente_document' => '123456789',
                'reservation_time' => Carbon::now()->addHours(3),
                'people_count' => 2,
            ],
            [
                'client_name' => 'Juan Pérez',
                'client_contact' => '3001234567',
                'cliente_document' => '123456789',
                'reservation_time' => Carbon::now()->addDays(1)->setTime(19, 30),
                'people_count' => 4,
            ],
            [
                'client_name' => 'Juan Pérez',
                'client_contact' => '3001234567',
                'cliente_document' => '123456789',
                'reservation_time' => Carbon::now()->addDays(3)->setTime(20, 0),
                'people_count' => 6,
            ],
        ];

        // --- Otros clientes ---
        $otrasReservas = [
            [
                'client_name' => 'María Gómez',
                'client_contact' => '3016549870',
                'cliente_document' => '987654321',
                'reservation_time' => Carbon::now()->addDays(2)->setTime(18, 45),
                'people_count' => 2,
            ],
            [
                'client_name' => 'Carlos Rodríguez',
                'client_contact' => '3129988776',
                'cliente_document' => '1122334455',
                'reservation_time' => Carbon::now()->addHours(8),
                'people_count' => 3,
            ],
            [
                'client_name' => 'Laura Martínez',
                'client_contact' => '3204455667',
                'cliente_document' => '5566778899',
                'reservation_time' => Carbon::now()->addDays(4)->setTime(21, 0),
                'people_count' => 5,
            ],
        ];

        // Combinar todo
        $reservas = array_merge($juanReservations, $otrasReservas);

        foreach ($reservas as $data) {
            $table = Table::inRandomOrder()->first();

            Reservation::create([
                'client_name' => $data['client_name'],
                'client_contact' => $data['client_contact'],
                'cliente_document' => $data['cliente_document'],
                'reservation_time' => $data['reservation_time'],
                'people_count' => $data['people_count'],
                'table_id' => $table->id,
                'user_id' => $mesero->id,
            ]);
        }

        $this->command->info('✅ Se generaron reservas de ejemplo, incluyendo múltiples para Juan Pérez.');
    }
}
