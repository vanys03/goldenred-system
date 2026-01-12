<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='alt-dashboard' />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard" />

        <div class="container-fluid py-4">

            <!-- Cards -->
            <div class="row">
                <!-- Ventas del Mes -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">
                                    Ventas en
                                    {{ isset($mesActual) && isset($meses[$mesActual]) ? $meses[$mesActual] : 'Mes inválido' }}
                                </p>
                                <h4 class="mb-0">${{ number_format($ventasMensuales, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Ventas Anuales -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">bar_chart</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Ventas del Año</p>
                                <h4 class="mb-0">${{ number_format($ventasAnuales, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clientes Totales -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-faded-primary shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">groups</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes Totales</p>
                                <h4 class="mb-0">{{ $clientesTotales }}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Clientes pendientes -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">schedule</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes pendientes</p>
                                <h4 class="mb-0">{{ $clientesPendientesPago  }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xl-3 col-sm-6 mb-4"> </div> -->

                <!-- Clientes con Deuda -->
                <!-- <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">priority_high</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes con deuda</p>
                                <h4 class="mb-0">{{ $clientesConDeuda }}</h4>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Clientes que pagaron -->
                <!-- <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">check_circle</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes que pagaron</p>
                                <h4 class="mb-0">{{ $clientesPagados }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4"> </div> -->

                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Estado de Clientes</h5>
                                <canvas id="estadoClientesChart" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold">Ventas Mensuales {{ now()->year }}</h5>
                                <canvas id="ventasMensualesChart" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header pb-0">
                            <h6 class="fw-bold text-center">Clientes de Hoy</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table id="tabla-clientes-hoy" class="table align-items-center mb-0">

                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nombre</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7">
                                                Día de Cobro</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Teléfono 1</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Teléfono 2</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Estatus del Mes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientesDeHoy as $cliente)
                                            @php
                                                $estado = $cliente->getEstadoPagoActual();
                                                $badgeColor = match ($estado['estado']) {
                                                    'corriente' => 'success',
                                                    'proximo' => 'warning',
                                                    'atrasado' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <tr>
                                                <td class="text-sm">{{ $cliente->nombre }}</td>
                                                <td class="text-sm text-center fw-bold" style="color: orange;">
                                                    {{ $cliente->dia_cobro }}
                                                </td>
                                                <td class="text-sm">{{ $cliente->telefono1 }}</td>
                                                <td class="text-sm">{{ $cliente->telefono2 }}</td>
                                                <td class="text-sm">
                                                    <span class="badge bg-{{ $badgeColor }}">
                                                        {{ $estado['mensaje'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-secondary">No hay clientes activos
                                                    para hoy.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header pb-0">
                            <h6 class="fw-bold text-center text-danger">Clientes con Pago Pendiente</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table id="tabla-clientes-atrasados" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nombre
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                                Día de Cobro</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Teléfono 1</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Teléfono 2</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Último
                                                mes pagado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientesAtrasados as $cliente)
                                            @php
                                                $estado = $cliente->getEstadoPagoActual();
                                            @endphp
                                            <tr>
                                                <td class="text-sm">{{ $cliente->nombre }}</td>
                                                <td class="text-sm text-center fw-bold" style="color: orange;">
                                                    {{ $cliente->dia_cobro }}</td>
                                                <td class="text-sm">{{ $cliente->telefono1 }}</td>
                                                <td class="text-sm">{{ $cliente->telefono2 }}</td>
                                                <td class="text-sm">
                                                    <span class="badge bg-danger">{{ $estado['mensaje'] }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-secondary">Todos los clientes están
                                                    al corriente ✨</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </main>
    @include('dashboard.partials.scripts')
    @include('dashboard.partials.script')
</x-layout>