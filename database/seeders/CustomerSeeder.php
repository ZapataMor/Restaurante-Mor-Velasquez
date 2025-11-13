<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Juan Pérez',
                'phone' => '555-2001',
                'email' => 'juan@email.com',
            ],
            [
                'name' => 'María González',
                'phone' => '555-2002',
                'email' => 'maria@email.com',
            ],
            [
                'name' => 'Roberto Sánchez',
                'phone' => '555-2003',
                'email' => 'roberto@email.com',
            ],
            [
                'name' => 'Laura Martínez',
                'phone' => '555-2004',
                'email' => 'laura@email.com',
            ],
            [
                'name' => 'Carlos Ruiz',
                'phone' => '555-2005',
                'email' => 'carlos@email.com',
            ],
            [
                'name' => 'Ana Fernández',
                'phone' => '555-2006',
                'email' => 'ana@email.com',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Clientes adicionales
        Customer::factory(10)->create();
    }
}