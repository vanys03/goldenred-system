<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClienteRenta;
use App\Models\User;

class Renta extends Model
{
    use HasFactory;

    protected $table = 'rentas';

    protected $fillable = [
        'cliente_renta_id',
        'user_id',
        'meses',
        'descuento',
        'recargo_domicilio',
        'fecha_venta',
        'subtotal',
        'total',
        'estado',
        'tipo_pago',
    ];

    public function cliente()
    {
        return $this->belongsTo(ClienteRenta::class, 'cliente_renta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

