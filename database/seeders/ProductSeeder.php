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
                'category' => 'Plato Fuerte',
                'description' => 'Pizza clásica con tomate, mozzarella y albahaca',
                'price' => 12.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Pizza Pepperoni',
                'category' => 'Plato Fuerte',
                'description' => 'Pizza con pepperoni y queso mozzarella',
                'price' => 14.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'category' => 'Plato Fuerte',
                'description' => 'Pasta con salsa de carne tradicional',
                'price' => 10.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Hamburguesa Clásica',
                'category' => 'Plato Fuerte',
                'description' => 'Hamburguesa con carne, lechuga, tomate y queso',
                'price' => 9.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Ensalada César',
                'category' => 'Entrada',
                'description' => 'Ensalada con pollo, lechuga, crutones y aderezo césar',
                'price' => 8.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Pollo a la Parrilla',
                'category' => 'Plato Fuerte',
                'description' => 'Pechuga de pollo a la parrilla con guarnición',
                'price' => 11.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Tacos de Pollo',
                'category' => 'Plato Fuerte',
                'description' => 'Tacos de pollo con aguacate y salsa',
                'price' => 7.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Lasagna',
                'category' => 'Plato Fuerte',
                'description' => 'Lasagna de carne con salsa bechamel',
                'price' => 13.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Sopa de Tomate',
                'category' => 'Entrada',
                'description' => 'Sopa cremosa de tomate con albahaca',
                'price' => 6.99,
                'image' => null,
                'status' => 'Activo',
            ],
            [
                'name' => 'Brownie de Chocolate',
                'category' => 'Postre',
                'description' => 'Brownie con nueces y helado de vainilla',
                'price' => 5.99,
                'image' => null,
                'status' => 'Activo',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
