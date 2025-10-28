<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'number' => $i,
                'capacity' => rand(2, 6),
                'status' => 'disponible',
            ]);
        }
    }
}
