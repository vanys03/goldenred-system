<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='clientes' />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Clientes" />

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Clientes</h5>
                    @can('Crear clientes')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCliente">
                            <span class="material-icons align-middle">add</span> Agregar Cliente
                        </button>
                    @endcan
                </div>

                {{-- Loader --}}
                <div id="loader-clientes" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                @if (!$clientes->isEmpty())
                    <table id="tabla-clientes" class="table align-items-center mb-0 w-100 d-none">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 1</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 2</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Día de cobro</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Zona</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Referencias</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Acciones</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
    <tr>
        <td>
    <h6 class="mb-0 text-xs {{ $cliente->tipo === 'A' ? 'text-danger' : '' }}">
        {{ $cliente->nombre }}
    </h6>
</td>

        <td>
            <p class="text-xs mb-0">{{ $cliente->telefono1 }}</p>
        </td>
        <td>
            <p class="text-xs mb-0">{{ $cliente->telefono2 }}</p>
        </td>
        <td>
            <p class="text-xs mb-0 text-warning">{{ $cliente->dia_cobro }}</p>
        </td>
        <td>
            <p class="text-xs mb-0">{{ $cliente->zona }}</p>
        </td>
        <td>
            <p class="text-xs mb-0" style="white-space: normal;">{{ $cliente->referencias }}</p>
        </td>
        <td class="text-center">
            <button class="btn btn-link text-success p-0 mx-1 btn-modal" title="Editar"
                data-url="{{ route('clientes.edit-modal', $cliente->id) }}">
                <span class="material-icons">edit</span>
            </button>
              @can('Eliminar clientes')
<button class="btn btn-link text-danger p-0 mx-1 btn-modal"
    title="Eliminar"
    data-url="{{ route('clientes.delete-modal', $cliente->id) }}">
    <span class="material-icons">delete</span>
</button>
@endcan

        </td>
        <td>
            @if ($cliente->activo)
                <span class="badge bg-success text-white text-xs">Activo</span>
            @else
                <span class="badge bg-secondary text-white text-xs">Inactivo</span>
            @endif
        </td>
    </tr>
@endforeach

                        </tbody>
                    </table>
                @else
                    <div class="text-center text-xs py-4">
                        No hay clientes registrados.
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal Crear Cliente --}}
        @include('clientes.partials.modal-create')

        {{-- Toast --}}
        @include('components.alert-toast')
        @include('clientes.partials.scripts')
        @include('components.modales')

        {{-- Loader --}}


        {{-- Modal dinámico --}}
        <div class="modal fade" id="modalDinamico" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" id="modal-dialog-dinamico">
                <div class="modal-content" id="contenido-modal"></div>
            </div>
        </div>
    </main>
</x-layout>