<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar modelos relacionados
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

    /**
     * Eventos automáticos para recalcular total del item
     * y actualizar total de la orden.
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de guardar, calcular subtotal del item
        static::saving(function ($item) {
            $item->total = $item->price * $item->quantity;
        });

        // Después de guardar, recalcular total de la orden
        static::saved(function ($item) {
            $item->order->calculateTotal();
        });

        // Después de eliminar, recalcular total de la orden
        static::deleted(function ($item) {
            $item->order->calculateTotal();
        });
    }
}
