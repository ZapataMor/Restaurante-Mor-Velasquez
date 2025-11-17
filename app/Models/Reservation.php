<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_contact',
        'cliente_document',
        'people_count',
        'reservation_time',
        'status',
        'user_id', // mesero asignado (opcional)
        'notes',
    ];

    // Reserva puede tener un mesero asignado
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una reserva tiene **una sola orden**
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
