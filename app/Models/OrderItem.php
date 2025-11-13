<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_item_id';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'notes', 'status'];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Eventos para el descuento automático de ingredientes
    protected static function booted()
    {
        static::updated(function ($orderItem) {
            if ($orderItem->isDirty('status') && $orderItem->status === 'Listo') {
                $orderItem->deductIngredients();
            }
        });
    }

    public function deductIngredients()
    {
        $product = $this->product;
        $recipes = $product->recipes;

        foreach ($recipes as $recipe) {
            $ingredient = $recipe->ingredient;
            $quantityToDeduct = $recipe->quantity * $this->quantity;

            // Actualizar stock
            $ingredient->current_stock -= $quantityToDeduct;
            $ingredient->save();
            $ingredient->updateStatus();

            // Registrar movimiento
            InventoryMovement::create([
                'ingredient_id' => $ingredient->ingredient_id,
                'user_id' => $this->order->waiter_id,
                'type' => 'Salida',
                'quantity' => $quantityToDeduct,
                'reason' => 'Preparación de orden: ' . $product->name,
                'reference_id' => $this->order_id,
            ]);

            // Verificar disponibilidad del producto
            $product->checkAvailability();
        }
    }

    // Calcular subtotal del item
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}