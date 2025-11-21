<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar modelo relacionado
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;

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

    /**
     * Determina el estado real de la mesa basándose en órdenes y reservas
     */
    public function realStatus()
    {
        $now = now();

        // 🔴 PRIORIDAD 1: Si tiene una orden activa (abierta o en proceso), está OCUPADA
        $hasActiveOrder = $this->orders()
            ->whereIn('status', ['abierta', 'en_proceso'])
            ->exists();

        if ($hasActiveOrder) {
            return 'Ocupada';
        }

        // 🔴 PRIORIDAD 2: Si tiene una reserva confirmada que YA LLEGÓ su hora (pero aún no completada)
        $arrivedReservation = $this->reservations()
            ->where('status', 'confirmada') // Solo las confirmadas (no completadas ni canceladas)
            ->whereDate('reservation_time', $now->toDateString())
            ->where('reservation_time', '<=', $now) // La hora ya pasó o es ahora
            ->where('reservation_time', '>=', $now->copy()->subHours(2)) // Tolerancia de 2 horas
            ->first();

        if ($arrivedReservation) {
            return 'Ocupada'; // El cliente llegó, está ocupada
        }

        // 🟡 PRIORIDAD 3: Si tiene una reserva confirmada PRÓXIMA (aún no llega la hora)
        $upcomingReservation = $this->reservations()
            ->where('status', 'confirmada')
            ->whereDate('reservation_time', $now->toDateString())
            ->whereBetween('reservation_time', [
                $now->copy()->addMinutes(1),  // Desde 1 minuto en el futuro
                $now->copy()->addHours(24)     // Hasta el final del día
            ])
            ->first();

        if ($upcomingReservation) {
            return 'Reservada'; // Tiene una reserva pero aún no llega la hora
        }

        // 🟢 PRIORIDAD 4: Si no hay órdenes activas ni reservas confirmadas, está DISPONIBLE
        return 'Disponible';
    }

    /**
     * Obtiene la orden activa de la mesa (si existe)
     */
    public function activeOrder()
    {
        return $this->orders()
            ->whereIn('status', ['abierta', 'en_proceso'])
            ->first();
    }

    /**
     * Verifica si tiene una orden activa
     */
    public function hasActiveOrder($reservation = null)
    {
        $query = $this->orders()->whereIn('status', ['abierta', 'en_proceso']);
        
        // Si se pasa una reserva, verificar que NO sea de esa reserva
        if ($reservation) {
            $query->where('reservation_id', '!=', $reservation->id);
        }
        
        return $query->exists();
    }

    /**
     * Obtiene la reserva activa (cliente ya llegó, esperando orden)
     */
    public function activeReservation()
    {
        $now = now();
        
        return $this->reservations()
            ->where('status', 'confirmada') // Solo confirmadas (no completadas)
            ->whereDate('reservation_time', $now->toDateString())
            ->where('reservation_time', '<=', $now)
            ->where('reservation_time', '>=', $now->copy()->subHours(2))
            ->first();
    }

    /**
     * Obtiene reservas futuras (próximas en el día)
     */
    public function futureReservation()
    {
        $now = now();
        
        return $this->reservations()
            ->where('status', 'confirmada')
            ->whereDate('reservation_time', $now->toDateString())
            ->where('reservation_time', '>', $now)
            ->orderBy('reservation_time')
            ->first();
    }

}
