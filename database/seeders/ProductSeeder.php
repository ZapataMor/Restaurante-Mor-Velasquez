<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Pizza Margherita',
                'description' => 'Pizza clásica con tomate, mozzarella y albahaca',
                'price' => 12.99,
                'available' => true,
            ],
            [
                'name' => 'Pizza Pepperoni',
                'description' => 'Pizza con pepperoni y queso mozzarella',
                'price' => 14.99,
                'available' => true,
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Pasta con salsa de carne tradicional',
                'price' => 10.99,
                'available' => true,
            ],
            [
                'name' => 'Hamburguesa Clásica',
                'description' => 'Hamburguesa con carne, lechuga, tomate y queso',
                'price' => 9.99,
                'available' => true,
            ],
            [
                'name' => 'Ensalada César',
                'description' => 'Ensalada con pollo, lechuga, crutones y aderezo césar',
                'price' => 8.99,
                'available' => true,
            ],
            [
                'name' => 'Pollo a la Parrilla',
                'description' => 'Pechuga de pollo a la parrilla con guarnición',
                'price' => 11.99,
                'available' => true,
            ],
            [
                'name' => 'Tacos de Pollo',
                'description' => 'Tacos de pollo con aguacate y salsa',
                'price' => 7.99,
                'available' => true,
            ],
            [
                'name' => 'Lasagna',
                'description' => 'Lasagna de carne con salsa bechamel',
                'price' => 13.99,
                'available' => true,
            ],
            [
                'name' => 'Sopa de Tomate',
                'description' => 'Sopa cremosa de tomate con albahaca',
                'price' => 6.99,
                'available' => true,
            ],
            [
                'name' => 'Brownie de Chocolate',
                'description' => 'Brownie con nueces y helado de vainilla',
                'price' => 5.99,
                'available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}