<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas_historial' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Historial de ventas" />
        <!-- End Navbar -->

        <div class="card m-4">
            @can('Exportar ventas')
            <div class="d-flex justify-content-end p-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalExportarVentas">
                    <i class="material-icons">download</i> Exportar Excel
                </button>
            </div>
            @endcan

            <div class="table-responsive p-3">
                <table id="tabla-ventas" class="table w-100 d-none">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Fecha Venta</th>
                            <th>Método de pago</th>
                            <th>Total</th>

                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->cliente->nombre }}</td>
                                <td>{{ $venta->usuario->name }}</td>
                                <td>{{ $venta->created_at->format('Y-m-d') }}
                                    <br><small>{{ $venta->created_at->format('h:i A') }}</small>
                                </td>
                                <td>{{ ucfirst($venta->tipo_pago ?? 'N/A') }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-link text-info p-0 mx-1 btn-ver-venta" title="Ver"
                                        data-id="{{ $venta->id }}" data-bs-toggle="modal"
                                        data-bs-target="#modalDetalleVenta">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                    @can('Eliminar ventas')
                                        <button type="button" class="btn btn-link text-danger p-0 mx-1 btn-modalEliminarVenta"
                                            data-id="{{ $venta->id }}" data-cliente="{{ $venta->cliente->nombre }}"
                                            title="Eliminar">
                                            <span class="material-icons">delete_forever</span>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>


    </main>
    @include('ventas_historial.partials.modal-confirmacion')
    @include('ventas_historial.partials.scripts')
    @include('ventas_historial.partials.modal-eliminar')
    @include('ventas_historial.partials.modal-exportar-ventas')


</x-layout>