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

    public function initials()
    {
        $name = $this->name ?? '';

        // separar el nombre por espacios
        $parts = explode(' ', trim($name));

        // tomar la primera letra de los dos primeros nombres
        $initials = '';

        if (isset($parts[0])) {
            $initials .= strtoupper(substr($parts[0], 0, 1));
        }

        if (isset($parts[1])) {
            $initials .= strtoupper(substr($parts[1], 0, 1));
        }

        return $initials;
    }

    /**
     * Scope para obtener solo personal activo
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope para obtener solo meseros
     */
    public function scopeWaiters($query)
    {
        return $query->where('role', 'mesero');
    }

    /**
     * Accessor para el nombre del rol en español
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrador',
            'mesero' => 'Mesero',
            'recepcionista' => 'Recepcionista',
            'chef' => 'Chef',
            default => 'Empleado',
        };
    }

}
