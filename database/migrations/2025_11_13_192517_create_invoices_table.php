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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');

            // Relación con la orden
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Cliente (si viene de reserva o si se agrega manual)
            $table->string('client_name')->nullable();
            $table->string('client_document')->nullable();

            // Información económica
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);      // IVA u otros impuestos
            $table->decimal('discount', 10, 2)->default(0); // Descuentos aplicados
            $table->decimal('total', 10, 2)->default(0);    // Total final a pagar

            // Método de pago
            $table->enum('payment_method', [
                'Efectivo',
                'Tarjeta',
                'Transferencia',
                'Mixto'
            ])->default('Efectivo');

            // Estado de la factura
            $table->enum('status', [
                'Pagada',
                'Anulada',
                'Pendiente'
            ])->default('Pendiente');

            // Auditoría
            $table->foreignId('generated_by') // Cajero que generó la factura
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
