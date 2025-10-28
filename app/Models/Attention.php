<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attention extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'status',
        'user_id',
    ];

    // 🔗 Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
