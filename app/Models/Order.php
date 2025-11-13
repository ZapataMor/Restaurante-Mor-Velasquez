<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = ['table_id', 'customer_id', 'waiter_id', 'status', 'type'];

    // Relaciones
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }

    // Calcular total de la orden
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->orderItems as $item) {
            $total += $item->quantity * $item->product->price;
        }
        return $total;
    }

    // Scopes
    public function scopeExtra($query)
    {
        return $query->where('type', 'Extra');
    }

    public function scopeNormal($query)
    {
        return $query->where('type', 'Normal');
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['En Vista', 'Confirmada', 'En Preparación']);
    }

    public function scopePendingPayment($query)
    {
        return $query->where('status', 'Entregada');
    }
}