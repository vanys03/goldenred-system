<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Actividad;

class RegistrarSalida
{
    public function handle(Logout $event)
    {
        $actividad = Actividad::where('usuario_id', $event->user->id)
            ->whereDate('fecha', now()->toDateString())
            ->whereNull('hora_salida')
            ->latest()
            ->first();

        if ($actividad) {
            $actividad->update([
                'hora_salida' => now()->toTimeString(),
            ]);
        }
    }
}
