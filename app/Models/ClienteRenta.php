<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRenta extends Model
{
    use HasFactory;

    protected $table = 'clientes_rentas';

    protected $fillable = [
        'nombre',
        'telefono1',
        'dia_pago',
        'direccion',
        'coordenadas',
        'referencias',
        'precio',
    ];

    public function rentas()
    {
        return $this->hasMany(Renta::class, 'cliente_renta_id');
    }
}
