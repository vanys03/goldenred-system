@php
    $hora = now()->hour;
    if ($hora < 12) {
        $saludo = 'Buenos días';
        $emoji = '☀️';
    } elseif ($hora < 19) {
        $saludo = 'Buenas tardes';
        $emoji = '🌇';
    } else {
        $saludo = 'Buenas noches';
        $emoji = '🌙';
    }
@endphp

<x-layout bodyClass="g-sidenav-show bg-gray-100">
    <x-navbars.sidebar activePage='alt-dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Inicio" />

        <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div style="background: white; padding: 3rem 2rem; width: 100%; max-width: 1100px; text-align: center;">
                
                   <img src="https://cdn-icons-png.flaticon.com/128/4814/4814852.png"
                 alt="Welcome" width="90" height="90" class="mb-4">


                <h2 class="text-gray-800 font-weight-bold mb-3" style="font-size: 1.9rem;">
                    {{ $saludo }}, {{ auth()->user()->name }} {!! $emoji !!}
                </h2>

                <p class="text-muted mb-4" style="font-size: 1.1rem;">
                    Bienvenido(a) al sistema. Usa el menú lateral para comenzar tu jornada.
                </p>

                <div class="container-fluid d-flex justify-content-center align-items-center" style="max-width: 600px; text-align: center; ">
                <blockquote class="blockquote" style="font-style: italic; color: #6c757d; font-size: 1.1rem;">
                    "El secreto para salir adelante es comenzar." — Mark Twain
                </blockquote>
                </div>
                
                
            </div>
            
        </div>
        <!-- Tabla: Clientes de Hoy -->
<div class="row mt-4 justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-center">Clientes de Hoy</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
                <div class="table-responsive">
                    <table id="tabla-clientes-hoy" class="table align-items-center mb-0">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class="text-center">Día de Cobro</th>
                                <th>Teléfono 1</th>
                                <th>Teléfono 2</th>
                                <th>Estatus del Mes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientesDeHoy as $cliente)
                                @php
                                    $estado = $cliente->getEstadoPagoActual();
                                    $badgeColor = match($estado['estado']) {
                                        'corriente' => 'success',
                                        'proximo' => 'warning',
                                        'atrasado' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td class="text-center fw-bold" style="color: orange;">{{ $cliente->dia_cobro }}</td>
                                    <td>{{ $cliente->telefono1 }}</td>
                                    <td>{{ $cliente->telefono2 }}</td>
                                    <td><span class="badge bg-{{ $badgeColor }}">{{ $estado['mensaje'] }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-secondary">No hay clientes activos para hoy.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla: Clientes con Pago Pendiente -->
<div class="row mt-4 justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-center text-danger">Clientes con Pago Pendiente</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
                <div class="table-responsive">
                    <table id="tabla-clientes-atrasados" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class="text-center">Día de Cobro</th>
                                <th>Teléfono 1</th>
                                <th>Teléfono 2</th>
                                <th>Último Mes Pagado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientesAtrasados as $cliente)
                                @php $estado = $cliente->getEstadoPagoActual(); @endphp
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td class="text-center fw-bold" style="color: orange;">{{ $cliente->dia_cobro }}</td>
                                    <td>{{ $cliente->telefono1 }}</td>
                                    <td>{{ $cliente->telefono2 }}</td>
                                    <td><span class="badge bg-danger">{{ $estado['mensaje'] }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-secondary">Todos los clientes están al corriente ✨</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    </main>

    @include('dashboard.partials.script')
</x-layout>
