<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $primaryKey = 'ingredient_id';
    protected $fillable = ['name', 'description', 'unit_measure', 'current_stock', 'reorder_point', 'status'];

    public function updateStatus()
    {
        if ($this->current_stock <= 0) {
            $this->status = 'Agotado';
        } elseif ($this->current_stock <= $this->reorder_point) {
            $this->status = 'Por Agotarse';
        } else {
            $this->status = 'Suficiente';
        }
        $this->save();
    }

    // Relaciones
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'ingredient_id');
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'ingredient_id');
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->where('status', 'Por Agotarse')->orWhere('status', 'Agotado');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'Suficiente');
    }
}