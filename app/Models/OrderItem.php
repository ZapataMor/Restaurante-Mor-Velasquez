<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar los modelos relacionados
use App\Models\Order;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'notes',
        'quantity',
        'price',
        'total',
        'status',
    ];

    // Cada item pertenece a una orden
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Cada item pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
