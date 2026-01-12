<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class Cliente extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nombre',
        'telefono1',
        'telefono2',
        'fecha_contrato',
        'dia_cobro',
        'paquete_id',
        'Mac',
        'IP',
        'direccion',
        'coordenadas',
        'referencias',
        'torre',
        'panel',
        'activo',
        'equiposregresados', // NUEVO
        'zona',    // NUEVO
        'tipo',
    ];

    protected $casts = [
        'fecha_contrato' => 'date',
    ];

    public function getEstadoPagoActual()
    {
        $hoy = now()->startOfDay();
        $ultimaVenta = $this->ventas->sortByDesc('fecha_venta')->first();

        if (!$ultimaVenta) {
            return ['estado' => 'atrasado', 'mensaje' => 'Sin pagos registrados'];
        }

        $periodoFin = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        $mesAnio = ucfirst($periodoFin->locale('es')->isoFormat('MMMM [de] YYYY'));

        if ($hoy->lt($periodoFin)) {
            $diasRestantes = $hoy->diffInDays($periodoFin);
            if ($diasRestantes <= 5) {
                return ['estado' => 'proximo', 'mensaje' => "Próximo a pagar. Cubierto hasta {$mesAnio}"];
            } else {
                return ['estado' => 'corriente', 'mensaje' => "Al corriente. Pagado hasta {$mesAnio}"];
            }
        }

        return ['estado' => 'atrasado', 'mensaje' => "Atrasado. Último mes cubierto: {$mesAnio}"];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('cliente')
            ->logOnly([
                'nombre',
                'telefono1',
                'telefono2',
                'fecha_contrato',
                'dia_cobro',
                'paquete_id',
                'Mac',
                'IP',
                'direccion',
                'coordenadas',
                'referencias',
                'torre',
                'panel',
                'zona',
                'tipo',    // NUEVO
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->merge([
            'cliente_nombre' => $this->nombre,
        ]);
    }

    public function scopeOnlyBasicFields($query)
    {
        return $query->select('id', 'nombre', 'telefono1', 'fecha_contrato');
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function ventaPendiente()
    {
        $ultimaVenta = $this->ventas()->latest()->first();
        return !$ultimaVenta || $ultimaVenta->estado == 'pendiente';
    }
}
