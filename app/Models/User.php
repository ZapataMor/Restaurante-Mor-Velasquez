<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function ordersAsWaiter()
    {
        return $this->hasMany(Order::class, 'waiter_id');
    }

    public function invoicesCreated()
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'user_id');
    }

    // Scopes para roles
    public function scopeAdmins($query)
    {
        return $query->where('role', 'Administrador');
    }

    public function scopeWaiters($query)
    {
        return $query->where('role', 'Mesero');
    }

    public function scopeChefs($query)
    {
        return $query->where('role', 'Chef');
    }

    public function scopeReceptionists($query)
    {
        return $query->where('role', 'Recepcionista');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Helpers
    public function isAdmin()
    {
        return $this->role === 'Administrador';
    }

    public function isWaiter()
    {
        return $this->role === 'Mesero';
    }

    public function isChef()
    {
        return $this->role === 'Chef';
    }

    public function isReceptionist()
    {
        return $this->role === 'Recepcionista';
    }

    public function isActive()
    {
        return $this->active === true;
    }

    // Método para nombre del rol en español
    public function getRoleNameAttribute()
    {
        return $this->role;
    }
}