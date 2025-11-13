<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    protected $fillable = ['name', 'description', 'price', 'available'];

    // Relaciones
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'product_id');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function checkAvailability()
    {
        $recipes = $this->recipes;
        foreach ($recipes as $recipe) {
            if ($recipe->ingredient->status === 'Agotado') {
                $this->available = false;
                $this->save();
                return false;
            }
        }
        $this->available = true;
        $this->save();
        return true;
    }
}