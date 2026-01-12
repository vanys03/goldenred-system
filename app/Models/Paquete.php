<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Paquete extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nombre',
        'precio',
    ];

    /**
     * Relación con el modelo Cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    /**
     * Configuración de auditoría con Spatie
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('paquete')
            ->logOnly(['nombre', 'precio'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
