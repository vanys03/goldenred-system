<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Actividad;
use Carbon\Carbon;

class CerrarSesionesInactivas extends Command
{
    protected $signature = 'sesiones:cierre-inactivo';
    protected $description = 'Cierra sesiones activas expiradas y registra la hora de salida';

    public function handle()
    {
        $limite = Carbon::now()->subMinutes(config('session.lifetime'));
        
        $actividadesAbiertas = Actividad::whereNull('hora_salida')
            ->whereDate('fecha', now()->toDateString())
            ->where('updated_at', '<', $limite)
            ->get();

        foreach ($actividadesAbiertas as $actividad) {
            $actividad->hora_salida = now()->toTimeString();
            $actividad->save();
            $this->info("Sesión cerrada para usuario ID {$actividad->usuario_id}");
        }
    }
}
