<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Table;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'table_id',
        'user_id',       // mesero
        'status',
        'payment_status',
        'total_amount',
    ];

    // Orden pertenece a una reserva (opcional)
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Orden pertenece a un mesero
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Orden pertenece a una mesa
    public function table()
    {
        return $this->belongsto(Table::class);
    }

    // Orden tiene muchos items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Orden puede tener una factura
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
