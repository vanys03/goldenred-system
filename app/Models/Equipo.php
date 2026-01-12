<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Equipo extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'equipo';

    protected $fillable = [
        'cliente_id',
        'marca_antena',
        'modelo_antena',
        'numero_serie_antena',
        'marca_router',
        'modelo_router',
        'numero_serie_router',
    ];

    /**
     * Relación con clientes
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Configuración del log de auditoría
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('equipo')
            ->logOnly([
                'cliente_id',
                'marca_antena',
                'modelo_antena',
                'numero_serie_antena',
                'marca_router',
                'modelo_router',
                'numero_serie_router',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Agrega información del cliente al log antes de guardarlo
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        // Forzar carga del cliente si no está cargado
        if (!$this->relationLoaded('cliente')) {
            $this->load('cliente');
        }

        if ($this->cliente) {
            $activity->properties = $activity->properties->merge([
                'cliente_id' => $this->cliente->id,
                'cliente_nombre' => $this->cliente->nombre,
            ]);
        }
    }
}
