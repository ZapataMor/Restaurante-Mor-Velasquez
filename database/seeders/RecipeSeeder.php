<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener productos e ingredientes
        $pizzaMargherita = Product::where('name', 'Pizza Margherita')->first();
        $pizzaPepperoni = Product::where('name', 'Pizza Pepperoni')->first();
        $spaghetti = Product::where('name', 'Spaghetti Bolognese')->first();
        $hamburguesa = Product::where('name', 'Hamburguesa Clásica')->first();
        $ensalada = Product::where('name', 'Ensalada César')->first();
        $polloParrilla = Product::where('name', 'Pollo a la Parrilla')->first();
        $tacos = Product::where('name', 'Tacos de Pollo')->first();

        $tomate = Ingredient::where('name', 'Tomate')->first();
        $queso = Ingredient::where('name', 'Queso Mozzarella')->first();
        $harina = Ingredient::where('name', 'Harina')->first();
        $pasta = Ingredient::where('name', 'Pasta')->first();
        $carne = Ingredient::where('name', 'Carne Molida')->first();
        $lechuga = Ingredient::where('name', 'Lechuga')->first();
        $pollo = Ingredient::where('name', 'Pollo')->first();
        $aguacate = Ingredient::where('name', 'Aguacate')->first();
        $pan = Ingredient::where('name', 'Pan Hamburguesa')->first();
        $cebolla = Ingredient::where('name', 'Cebolla')->first();
        $ajo = Ingredient::where('name', 'Ajo')->first();

        $recipes = [
            // Pizza Margherita
            ['product_id' => $pizzaMargherita->product_id, 'ingredient_id' => $tomate->ingredient_id, 'quantity' => 0.3],
            ['product_id' => $pizzaMargherita->product_id, 'ingredient_id' => $queso->ingredient_id, 'quantity' => 0.2],
            ['product_id' => $pizzaMargherita->product_id, 'ingredient_id' => $harina->ingredient_id, 'quantity' => 0.25],

            // Pizza Pepperoni
            ['product_id' => $pizzaPepperoni->product_id, 'ingredient_id' => $tomate->ingredient_id, 'quantity' => 0.3],
            ['product_id' => $pizzaPepperoni->product_id, 'ingredient_id' => $queso->ingredient_id, 'quantity' => 0.25],
            ['product_id' => $pizzaPepperoni->product_id, 'ingredient_id' => $harina->ingredient_id, 'quantity' => 0.25],

            // Spaghetti Bolognese
            ['product_id' => $spaghetti->product_id, 'ingredient_id' => $pasta->ingredient_id, 'quantity' => 0.2],
            ['product_id' => $spaghetti->product_id, 'ingredient_id' => $tomate->ingredient_id, 'quantity' => 0.15],
            ['product_id' => $spaghetti->product_id, 'ingredient_id' => $carne->ingredient_id, 'quantity' => 0.18],
            ['product_id' => $spaghetti->product_id, 'ingredient_id' => $cebolla->ingredient_id, 'quantity' => 0.05],
            ['product_id' => $spaghetti->product_id, 'ingredient_id' => $ajo->ingredient_id, 'quantity' => 0.01],

            // Hamburguesa Clásica
            ['product_id' => $hamburguesa->product_id, 'ingredient_id' => $carne->ingredient_id, 'quantity' => 0.15],
            ['product_id' => $hamburguesa->product_id, 'ingredient_id' => $lechuga->ingredient_id, 'quantity' => 0.05],
            ['product_id' => $hamburguesa->product_id, 'ingredient_id' => $tomate->ingredient_id, 'quantity' => 0.08],
            ['product_id' => $hamburguesa->product_id, 'ingredient_id' => $pan->ingredient_id, 'quantity' => 1.0],
            ['product_id' => $hamburguesa->product_id, 'ingredient_id' => $cebolla->ingredient_id, 'quantity' => 0.03],

            // Ensalada César
            ['product_id' => $ensalada->product_id, 'ingredient_id' => $lechuga->ingredient_id, 'quantity' => 0.1],
            ['product_id' => $ensalada->product_id, 'ingredient_id' => $pollo->ingredient_id, 'quantity' => 0.12],

            // Pollo a la Parrilla
            ['product_id' => $polloParrilla->product_id, 'ingredient_id' => $pollo->ingredient_id, 'quantity' => 0.2],
            ['product_id' => $polloParrilla->product_id, 'ingredient_id' => $cebolla->ingredient_id, 'quantity' => 0.05],

            // Tacos de Pollo
            ['product_id' => $tacos->product_id, 'ingredient_id' => $pollo->ingredient_id, 'quantity' => 0.1],
            ['product_id' => $tacos->product_id, 'ingredient_id' => $aguacate->ingredient_id, 'quantity' => 0.08],
            ['product_id' => $tacos->product_id, 'ingredient_id' => $cebolla->ingredient_id, 'quantity' => 0.04],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}