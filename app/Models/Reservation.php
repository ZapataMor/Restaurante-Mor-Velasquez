<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservation_id';
    protected $fillable = ['customer_id', 'table_id', 'reservation_date', 'number_of_people', 'status', 'reservation_payment_made'];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Confirmada');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pendiente');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('reservation_date', today());
    }
}