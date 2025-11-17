<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Cada item pertenece a una orden
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Producto del menú
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Notas especiales para el chef
            $table->text('notes')->nullable();

            // Cantidad
            $table->unsignedInteger('quantity')->default(1);

            // Precio unitario del producto en el momento de la compra
            $table->decimal('price', 10, 2);

            // Total = price * quantity
            $table->decimal('total', 10, 2);

            // Estado del plato dentro del flujo de cocina
            $table->enum('status', [
                'pendiente',
                'preparando',
                'listo',
                'servido',
                'cancelado',
            ])->default('pendiente');


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
