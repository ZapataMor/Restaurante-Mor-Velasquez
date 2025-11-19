<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar modelo relacionado
use App\Models\Order;
use App\Models\Reservation;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'capacity',
        'status',
    ];

    // Relación: una mesa puede tener muchas órdenes
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


}
