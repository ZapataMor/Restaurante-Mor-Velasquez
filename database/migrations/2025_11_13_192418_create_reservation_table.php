<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->foreignId('customer_id')->constrained('customers', 'customer_id');
            $table->foreignId('table_id')->constrained('tables', 'table_id');
            $table->datetime('reservation_date');
            $table->integer('number_of_people');
            $table->enum('status', ['Pendiente', 'Confirmada', 'Cancelada', 'Finalizada'])->default('Pendiente');
            $table->boolean('reservation_payment_made')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};