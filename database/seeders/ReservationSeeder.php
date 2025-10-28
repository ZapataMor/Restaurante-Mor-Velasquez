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
        $mesero = User::where('role', 'mesero')->first();
        $table = Table::inRandomOrder()->first();

        Reservation::create([
            'client_name' => 'Juan Pérez',
            'client_contact' => '3001234567',
            'reservation_time' => Carbon::now()->addHours(2),
            'people_count' => 4,
            'table_id' => $table->id,
            'user_id' => $mesero->id,
        ]);
    }
}
