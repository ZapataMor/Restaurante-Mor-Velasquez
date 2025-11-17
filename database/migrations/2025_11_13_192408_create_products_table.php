<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Nombre del plato o producto
            $table->string('name');

            // Categoría del producto
            $table->enum('category', [
                'Entrada',
                'Plato Fuerte',
                'Bebida',
                'Postre',
                'Adicional'
            ]);

            // Descripción del producto
            $table->text('description')->nullable();

            // Precio del producto
            $table->decimal('price', 10, 2);

            // Imagen (ruta dentro de storage)
            $table->string('image')->nullable();

            // Estado: si aparece en el menú
            $table->enum('status', ['Activo', 'Inactivo'])
                  ->default('Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
