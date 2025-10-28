<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Bandeja Paisa', 'description' => 'Plato típico colombiano con frijoles, carne y chicharrón', 'price' => 28000, 'category' => 'Plato fuerte'],
            ['name' => 'Sopa de Mondongo', 'description' => 'Sopa tradicional con tripa y verduras', 'price' => 20000, 'category' => 'Entrada'],
            ['name' => 'Limonada Natural', 'description' => 'Refrescante bebida de limón', 'price' => 6000, 'category' => 'Bebida'],
            ['name' => 'Jugo de Mango', 'description' => 'Bebida natural de mango', 'price' => 7000, 'category' => 'Bebida'],
            ['name' => 'Postre de Maracuyá', 'description' => 'Delicioso postre artesanal', 'price' => 10000, 'category' => 'Postre'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
