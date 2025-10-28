<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@morvelasquez.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Carlos Gómez',
            'email' => 'mesero1@morvelasquez.com',
            'password' => Hash::make('mesero123'),
            'role' => 'mesero',
        ]);

        User::create([
            'name' => 'Laura Mendoza',
            'email' => 'cocinera1@morvelasquez.com',
            'password' => Hash::make('cocinera123'),
            'role' => 'cocinero',
        ]);

        User::create([
            'name' => 'Andrés Ruiz',
            'email' => 'recepcionista1@morvelasquez.com',
            'password' => Hash::make('recepcionista123'),
            'role' => 'recepcionista',
        ]);
    }
}
