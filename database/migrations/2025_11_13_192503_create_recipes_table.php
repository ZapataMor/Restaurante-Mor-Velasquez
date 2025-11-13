<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->foreignId('ingredient_id')->constrained('ingredients', 'ingredient_id');
            $table->decimal('quantity', 10, 2);
            $table->primary(['product_id', 'ingredient_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};