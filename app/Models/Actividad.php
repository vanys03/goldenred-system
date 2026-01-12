<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    protected $table = 'actividades'; 

    protected $fillable = [
        'usuario_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'ip',
        'dispositivo',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

