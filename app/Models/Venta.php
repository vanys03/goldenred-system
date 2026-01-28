<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Collection;

class Venta extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'estado',
        'meses',
        'descuento',
        'recargo_domicilio',
        'recargo_atraso',
        'tipo_pago',
        'fecha_venta',
        'subtotal',
        'total',
        'periodo_inicio',
        'periodo_fin',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('venta')
            ->logOnly([
                'usuario_id',
                'cliente_id',
                'estado',
                'meses',
                'descuento',
                'recargo_domicilio',
                'recargo_atraso',
                'tipo_pago',
                'fecha_venta',
                'subtotal',
                'total',
                'periodo_inicio',
                'periodo_fin',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $properties = $activity->properties;

        if (!$properties instanceof Collection) {
            $properties = collect($properties ?? []);
        }

        if ($this->cliente) {
            $activity->properties = $properties->merge([
                'cliente_id' => $this->cliente->id,
                'cliente_nombre' => $this->cliente->nombre,
            ]);
        }
    }
    protected $casts = [
    'fecha_venta' => 'datetime',
    'periodo_inicio' => 'datetime',
    'periodo_fin' => 'datetime',
];


}
