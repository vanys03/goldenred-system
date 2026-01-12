<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Actividad;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class RegistrarEntrada
{
    public function handle(Login $event)
    {
        $agent = new Agent();

        // Determinar si es móvil o computadora
        $dispositivo = $agent->isMobile() ? 'Móvil' : 'Computadora';

        Actividad::create([
            'usuario_id'   => $event->user->id,
            'fecha'        => now()->toDateString(),
            'hora_entrada' => now()->toTimeString(),
            'ip'           => Request::ip(),
            'dispositivo'  => $dispositivo,
        ]);
    }
}
