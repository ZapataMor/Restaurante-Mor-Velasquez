<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            [
                'name' => 'Tomate',
                'description' => 'Tomate fresco para salsas',
                'unit_measure' => 'kg',
                'current_stock' => 10.0,
                'reorder_point' => 2.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Queso Mozzarella',
                'description' => 'Queso para pizza',
                'unit_measure' => 'kg',
                'current_stock' => 8.0,
                'reorder_point' => 1.5,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Harina',
                'description' => 'Harina de trigo',
                'unit_measure' => 'kg',
                'current_stock' => 15.0,
                'reorder_point' => 3.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Pasta',
                'description' => 'Pasta seca',
                'unit_measure' => 'kg',
                'current_stock' => 12.0,
                'reorder_point' => 2.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Carne Molida',
                'description' => 'Carne de res molida',
                'unit_measure' => 'kg',
                'current_stock' => 6.0,
                'reorder_point' => 1.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Lechuga',
                'description' => 'Lechuga fresca',
                'unit_measure' => 'kg',
                'current_stock' => 5.0,
                'reorder_point' => 1.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Pollo',
                'description' => 'Pechuga de pollo',
                'unit_measure' => 'kg',
                'current_stock' => 7.0,
                'reorder_point' => 1.5,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Aguacate',
                'description' => 'Aguacate hass',
                'unit_measure' => 'kg',
                'current_stock' => 4.0,
                'reorder_point' => 0.5,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Pan Hamburguesa',
                'description' => 'Pan para hamburguesa',
                'unit_measure' => 'unidades',
                'current_stock' => 20.0,
                'reorder_point' => 5.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Bacon',
                'description' => 'Tocino ahumado',
                'unit_measure' => 'kg',
                'current_stock' => 3.0,
                'reorder_point' => 0.5,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Cebolla',
                'description' => 'Cebolla blanca',
                'unit_measure' => 'kg',
                'current_stock' => 8.0,
                'reorder_point' => 1.0,
                'status' => 'Suficiente',
            ],
            [
                'name' => 'Ajo',
                'description' => 'Ajo fresco',
                'unit_measure' => 'kg',
                'current_stock' => 2.0,
                'reorder_point' => 0.3,
                'status' => 'Suficiente',
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}