<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->foreignId('order_id')->unique()->constrained('orders', 'order_id');
            $table->foreignId('customer_id')->constrained('customers', 'customer_id');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['Pendiente', 'Pagada'])->default('Pendiente');
            $table->enum('payment_method', ['Efectivo', 'Tarjeta', 'Transferencia'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};