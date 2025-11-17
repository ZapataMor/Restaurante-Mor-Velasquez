<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@restaurante.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '555-1001',
            'active' => true,
        ]);

        User::create([
            'name' => 'Ana García',
            'email' => 'recepcion@restaurante.com',
            'password' => Hash::make('password'),
            'role' => 'recepcionista',
            'phone' => '555-1002',
            'active' => true,
        ]);

        User::create([
            'name' => 'Luis Rodríguez',
            'email' => 'mesero@restaurante.com',
            'password' => Hash::make('password'),
            'role' => 'mesero',
            'phone' => '555-1003',
            'active' => true,
        ]);

        User::create([
            'name' => 'María López',
            'email' => 'chef@restaurante.com',
            'password' => Hash::make('password'),
            'role' => 'chef',
            'phone' => '555-1004',
            'active' => true,
        ]);

        User::create([
            'name' => 'Sofia Castro',
            'email' => 'mesero2@restaurante.com',
            'password' => Hash::make('password'),
            'role' => 'mesero',
            'phone' => '555-1005',
            'active' => true,
        ]);

        User::create([
            'name' => 'Luis Zapata',
            'email' => 'felipe@restaurante.com',
            'password' => 'admin1234',
            'role' => 'admin',
            'phone' => '555-1004',
            'active' => true,
        ]);

        // Usuarios adicionales de prueba
        User::factory(5)->create();
    }
}
