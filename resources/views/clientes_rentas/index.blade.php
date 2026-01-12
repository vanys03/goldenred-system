<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='clientes_rentas' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Clientes rentas" />

        @include('components.alert-toast')

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Clientes</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCliente">
                        <span class="material-icons align-middle">add</span> Agregar Cliente
                    </button>
                </div>

                @if($clientes->count())
                    <table id="tabla-clientes-rentas" class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Teléfono</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">Día de pago</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">Precio</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    {{-- Nombre --}}
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-xs">{{ $cliente->nombre }}</h6>
                                                <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 250px;"
                                                    title="{{ $cliente->direccion }}">
                                                    {{ $cliente->direccion }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Teléfono --}}
                                    <td>
                                        <p class="text-xs font-weight-normal mb-0">
                                            {{ $cliente->telefono1 }}
                                        </p>
                                    </td>

                                    {{-- Día de pago --}}
                                    <td class="align-middle text-center">
                                        <span class="badge bg-info text-white text-xs">
                                            {{ $cliente->dia_pago }}
                                        </span>
                                    </td>

                                    {{-- Precio --}}
                                    <td class="align-middle text-center">
                                        <span class="badge bg-success text-white text-xs">
                                            ${{ number_format($cliente->precio, 2) }}
                                        </span>
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="align-middle text-center">
                                        <button class="btn btn-link text-success p-0 mx-1" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarCliente{{ $cliente->id }}">
                                            <span class="material-icons">edit</span>
                                        </button>

                                        <button type="button" class="btn btn-link text-danger p-0 mx-1" title="Eliminar"
                                            data-bs-toggle="modal" data-bs-target="#modalEliminarCliente{{ $cliente->id }}">
                                            <span class="material-icons">delete_forever</span>
                                        </button>

                                        {{-- Modales únicos por cliente --}}
                                        @include('clientes_rentas.partials.modal-edit', ['cliente' => $cliente])
                                        @include('clientes_rentas.partials.modal-delete', ['cliente' => $cliente])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay clientes registrados.</p>
                @endif
            </div>
        </div>

        {{-- Modal de creación (solo una vez, fuera del loop) --}}
        @include('clientes_rentas.partials.modal-create')

    </main>
</x-layout>
