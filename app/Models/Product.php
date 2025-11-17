<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar modelo relacionado
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'image',
        'status',
    ];

    // Relación: un producto puede aparecer en muchos items de orden
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
