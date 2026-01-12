<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Console\Scheduling\Schedule;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
     // Agregamos la configuración para el scheduler
    
    ->withSchedule(function (Schedule $schedule) {
        // Aquí defines los comandos que quieras que se ejecuten automáticamente
        $schedule->command('sesiones:cierre-inactivo')->everyMinute();
    })

    ->withMiddleware(function (Middleware $middleware) {

        

        // Registrar middleware de Spatie manualmente
        $middleware->alias([
            'permission' => PermissionMiddleware::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
