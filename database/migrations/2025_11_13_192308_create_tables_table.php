<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id('table_id');
            $table->integer('number')->unique();
            $table->integer('capacity');
            $table->enum('status', ['Disponible', 'Ocupada', 'Reservada', 'Necesita Limpieza'])->default('Disponible');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tables');
    }
};