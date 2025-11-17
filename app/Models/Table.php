<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar modelo relacionado
use App\Models\Order;

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
}
