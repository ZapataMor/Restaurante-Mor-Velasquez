<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id('movement_id');
            $table->foreignId('ingredient_id')->constrained('ingredients', 'ingredient_id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->enum('type', ['Entrada', 'Salida']);
            $table->decimal('quantity', 10, 2);
            $table->string('reason');
            $table->foreignId('reference_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
};