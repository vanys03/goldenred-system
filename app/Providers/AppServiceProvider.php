<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listeners\RegistrarEntrada;
use App\Listeners\RegistrarSalida;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    Carbon::setLocale('es');
}


    protected $listen = [
    Login::class => [
        RegistrarEntrada::class,
    ],
    Logout::class => [
        RegistrarSalida::class,
    ],
];
}
