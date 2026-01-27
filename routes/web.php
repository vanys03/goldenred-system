<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ExportarVentasController;
use App\Http\Controllers\PaquetesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\NoCache;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\ClientesRentasController;
use App\Http\Controllers\{
    PlatformController,
    AccountController,
    AccountProfileController,
    ProfileAssignmentController
};
use App\Http\Controllers\RentasController;

Route::resource('platforms', PlatformController::class);
Route::resource('account-profiles', AccountProfileController::class);
Route::get('platforms/{platform}/accounts', [AccountController::class, 'byPlatform'])
    ->name('platforms.accounts');
Route::get('accounts/{account}/profiles', [AccountProfileController::class, 'byAccount'])
    ->name('accounts.profiles');
Route::post('/profiles/{profile}/assign', [AccountProfileController::class, 'assign'])
    ->name('profiles.assign');


Route::get('/telefonos', action: [TelefonoController::class, 'index'])->name('telefonos.index');




Route::get('/', function () {
    return redirect(Auth::check() ? route('alt-dashboard') : route('login'));
});

Route::middleware(['auth', NoCache::class,])->group(function () {


    Route::get('/tickets/perfil/{id}', [TicketController::class, 'perfil'])->name('ticket.perfil');
    Route::get('/ticket/perfil/{id}', [TicketController::class, 'reimprimirPerfil'])
        ->name('ticket.perfil.reimprimir');

    // Rutas de plataformas y perfiles
    Route::get('/platforms-historial/data', [ProfileAssignmentController::class, 'data'])
        ->name('platforms_historial.data');
    Route::get('/platforms/perfiles-ocupados/data', [AccountProfileController::class, 'dataPerfilesOcupados'])
        ->name('platforms.occupied-profiles.data');

    //-------------------------------------------------------------------


    // Rutas de rentas  
    Route::patch('rentas/{renta}/confirmar', [RentasController::class, 'confirmar'])
        ->name('rentas.confirmar');
    Route::patch('rentas/{renta}/cancelar', [RentasController::class, 'cancelar'])
        ->name('rentas.cancelar');
    Route::get('/rentas/historial', [RentasController::class, 'historial'])
    ->name('rentas_historial.index');
    Route::get('/clientes-rentas/buscar', [ClientesRentasController::class, 'buscar'])
    ->name('clientes_rentas.buscar');
    
    Route::resource('rentas', RentasController::class);   

    Route::get('tickets/rentas/{renta}/imprimible', [TicketController::class, 'imprimibleRenta'])
    ->name('tickets.rentas.imprimible');

    Route::get('/rentas/historial/data',
    [RentasController::class, 'data']
)->name('rentas_historial.data');

Route::get('/rentas/{id}/detalle',
    [RentasController::class, 'detalle']
)->name('rentas.detalle');

Route::delete('/rentas/{id}',
    [RentasController::class, 'destroy']
)->name('rentas.destroy');


    //-------------------------------------------------------------------

    //Rutas de cliente de rentas 
    
    Route::resource('clientes-rentas', ClientesRentasController::class);
    Route::get('clientes/buscar', [ClientesRentasController::class, 'buscar']) ->name('clientes.buscar');


    //-------------------------------------------------------------------



    Route::patch('/account-profiles/{profile}/unassign', [AccountProfileController::class, 'unassign'])
        ->name('account-profiles.unassign');
    Route::get('/plataformas/historial', [ProfileAssignmentController::class, 'index'])->name('plataformas_historial.index');
    Route::get('/alt-dashboard', DashboardController::class)->name('alt-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuariosController::class);

    Route::resource('roles', RolesController::class);

    Route::get('clientes/{id}/edit-modal', [ClientesController::class, 'editModal'])->name('clientes.edit-modal');
    Route::get('clientes/{id}/delete-modal', [ClientesController::class, 'deleteModal'])->name('clientes.delete-modal');

    Route::resource('clientes', ClientesController::class);

    Route::resource('equipos', EquipoController::class);

    Route::get('/actividades-data', [ActividadController::class, 'data'])->name('actividades.data');

    Route::resource('actividades', ActividadController::class);

    Route::resource('paquetes', PaquetesController::class);


    
    //-------------------------------------------------------------------

    //Rutas de cliente de ventas, corte eh historial 

    Route::get('/ventas/recargo/{cliente}', [VentasController::class, 'calcularRecargo']);
    Route::get('/ventas/buscar-clientes', [VentasController::class, 'buscarClientes'])->name('ventas.buscar-clientes');
    Route::get('/ventas/estado-cliente/{clienteId}', [VentasController::class, 'estadoCliente']);

    Route::resource('ventas', VentasController::class)->except(['show']);

    Route::get('historial', [VentasController::class, 'historial'])->name('ventas.historial');
    Route::get('corte', [VentasController::class, 'corte'])->name('ventas.corte');

    Route::resource('auditoria', AuditoriaController::class);
    Route::put('/ventas/{venta}', [VentasController::class, 'update'])->name('ventas.update');

    Route::get('/ventas/exportar', [ExportarVentasController::class, 'exportar'])->name('ventas.exportar');
    Route::resource('accounts', AccountController::class);

    Route::post('/ventas/pago-transferencia', 
    [VentasController::class, 'pagarPorTransferencia']
)->name('ventas.pago.transferencia');
Route::get('/ventas/corte/cerrar', [VentasController::class, 'cerrarCorteHoy'])
    ->name('ventas.corte.cerrar');
Route::get('/ventas/corte/filtrar', [VentasController::class, 'filtrarCorte'])
    ->name('ventas.corte.filtrar');


     //-------------------------------------------------------------------
    Route::post('/accounts/{account}/change-password', [AccountController::class, 'changePassword'])->name('accounts.changePassword');

});


Route::get('/api/ventas/{venta}', function (App\Models\Venta $venta) {
    return response()->json([
        'cliente' => $venta->cliente->nombre,
        'paquete' => optional($venta->cliente->paquete)->nombre ?? 'N/A',
        'meses' => $venta->meses,
        'descuento' => $venta->descuento,
        'recargo_domicilio' => $venta->recargo_domicilio,
        'recargo_atraso' => $venta->recargo_atraso ?? 0,
        'total' => $venta->total,
    ]);
});
Route::get('/ticket/imprimir/{venta}', [TicketController::class, 'imprimible'])->name('ticket.imprimible');
Route::get('/ventas/{venta}/ticket-a/{cliente}', [TicketController::class, 'tipoA'])->name('tickets.tipo-a');
Route::get('/ventas/{venta}/ticket-b/{cliente}', [TicketController::class, 'tipoB'])->name('tickets.tipo-b');
Route::get('/ventas/{venta}/ticket-c/{cliente}', [TicketController::class, 'tipoC'])->name('tickets.tipo-c');
Route::get('/ventas/{venta}/ticket-generico/{cliente}', [TicketController::class, 'generico'])->name('tickets.generico');

Route::get('/ventas/{id}/ticket', [TicketController::class, 'reimprimir'])->name('ventas.ticket');



require __DIR__ . '/auth.php';
