<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id';
    protected $fillable = ['order_id', 'customer_id', 'created_by', 'subtotal', 'tax', 'total', 'status', 'payment_method'];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pendiente');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'Pagada');
    }

    // Calcular impuestos y total
    public function calculateTotals($subtotal = null)
    {
        $subtotal = $subtotal ?: $this->order->calculateTotal();
        $tax = $subtotal * 0.16; // 16% de IVA
        $total = $subtotal + $tax;

        $this->subtotal = $subtotal;
        $this->tax = $tax;
        $this->total = $total;
        $this->save();

        return $total;
    }
}