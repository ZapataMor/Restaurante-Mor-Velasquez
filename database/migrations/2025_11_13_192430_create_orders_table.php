<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('table_id')->constrained('tables', 'table_id');
            $table->foreignId('customer_id')->nullable()->constrained('customers', 'customer_id');
            $table->foreignId('waiter_id')->constrained('users', 'id');
            $table->enum('status', ['En Vista', 'Confirmada', 'En Preparación', 'Lista', 'Entregada', 'Pagada'])->default('En Vista');
            $table->enum('type', ['Normal', 'Extra'])->default('Normal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};