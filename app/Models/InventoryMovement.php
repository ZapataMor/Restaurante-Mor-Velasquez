<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $primaryKey = 'movement_id';
    protected $fillable = ['ingredient_id', 'user_id', 'type', 'quantity', 'reason', 'reference_id'];

    // Relaciones
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Eventos para actualizar el estado del ingrediente
    protected static function booted()
    {
        static::created(function ($movement) {
            $movement->ingredient->updateStatus();
            
            // Actualizar disponibilidad de productos relacionados
            $recipes = $movement->ingredient->recipes;
            foreach ($recipes as $recipe) {
                $recipe->product->checkAvailability();
            }
        });
    }
}