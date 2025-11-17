<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación: usuario puede atender ordenes
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relación: usuario puede generar facturas
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'generated_by');
    }

    // Relación: usuario puede estar asignado a reservas (opcional)
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
