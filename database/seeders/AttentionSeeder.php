<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attention;
use App\Models\User;

class AttentionSeeder extends Seeder
{
    public function run(): void
    {
        $recepcionista = User::where('role', 'recepcionista')->first();

        Attention::create([
            'client_name' => 'Sofía Ramírez',
            'status' => 'en_espera',
            'user_id' => $recepcionista->id,
        ]);

        Attention::create([
            'client_name' => 'Daniel Castro',
            'status' => 'atendido',
            'user_id' => $recepcionista->id,
        ]);
    }
}
