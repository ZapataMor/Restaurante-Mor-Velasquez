<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Orden puede provenir de una reserva (opcional)
            $table->foreignId('reservation_id')
                  ->nullable()
                  ->constrained('reservations')
                  ->nullOnDelete();

            // Mesa donde se atiende al cliente
            $table->foreignId('table_id')
                  ->constrained('tables')
                  ->cascadeOnDelete();

            // Cliente
            $table->string('client_name')->nullable();
            $table->string('client_document')->nullable();

            // Mesero que atiende esta orden
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Estado de la orden
            $table->enum('status', ['abierta', 'en_proceso', 'completada', 'cancelada'])
                  ->default('abierta');

            // Estado del pago
            $table->enum('payment_status', ['pendiente', 'pagado'])
                  ->default('pendiente');

            // Total a pagar
            $table->decimal('total_amount', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
