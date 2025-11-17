<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importar los modelos relacionados
use App\Models\Order;
use App\Models\User;

class Invoice extends Model
{
    use HasFactory;

    // Si tu primary key es 'invoice_id' y no 'id'
    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'order_id',
        'client_name',
        'client_document',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'status',
        'generated_by', // usuario que generó la factura
    ];

    // Relación: factura pertenece a una orden
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación: factura fue generada por un usuario interno
    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
