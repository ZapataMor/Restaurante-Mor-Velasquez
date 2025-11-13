<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['number' => 1, 'capacity' => 4, 'status' => 'Disponible'],
            ['number' => 2, 'capacity' => 2, 'status' => 'Disponible'],
            ['number' => 3, 'capacity' => 6, 'status' => 'Disponible'],
            ['number' => 4, 'capacity' => 4, 'status' => 'Disponible'],
            ['number' => 5, 'capacity' => 8, 'status' => 'Disponible'],
            ['number' => 6, 'capacity' => 4, 'status' => 'Disponible'],
            ['number' => 7, 'capacity' => 2, 'status' => 'Disponible'],
            ['number' => 8, 'capacity' => 6, 'status' => 'Disponible'],
            ['number' => 9, 'capacity' => 4, 'status' => 'Disponible'],
            ['number' => 10, 'capacity' => 8, 'status' => 'Disponible'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}