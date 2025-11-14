<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['number', 'capacity', 'status'];

    // Relaciones
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Disponible');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'Ocupada');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'Reservada');
    }
}
