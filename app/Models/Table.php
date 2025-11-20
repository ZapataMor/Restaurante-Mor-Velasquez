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

    public function activeReservation()
    {
        $now = now();

        return $this->reservations()
            ->where('status', 'confirmada')
            ->where('reservation_time', '<=', $now)
            ->where('reservation_time', '>=', $now->copy()->subMinutes(90))
            ->first();
    }

    public function futureReservation()
    {
        $now = now();

        return $this->reservations()
            ->where('status', 'confirmada')
            ->where('reservation_time', '>', $now)
            ->orderBy('reservation_time', 'asc')
            ->first();
    }

    public function hasActiveOrder($activeReservation = null)
    {
        $query = $this->orders()
            ->whereIn('status', ['abierta', 'en_proceso']);

        // Si hay reserva activa, solo contar ORDENES DE ESA RESERVA
        if ($activeReservation) {
            $query->where('reservation_id', $activeReservation->id);
        }

        return $query->exists();
    }


    public function activeOrder()
    {
        return $this->orders()
            ->whereIn('status', ['abierta', 'en_proceso'])
            ->orderBy('created_at', 'desc')
            ->first();
    }


    public function getActiveOrder()
{
    return $this->orders()
        ->whereIn('status', ['abierta', 'en_proceso'])
        ->first();
}






}
