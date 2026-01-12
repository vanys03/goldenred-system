<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='paquetes' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Paquetes" />
        <!-- End Navbar -->

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Paquetes</h5>
                    @can('Crear paquetes')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPaquete">
                            <span class="material-icons align-middle">add</span> Agregar Paquete
                        </button>
                    @endcan
                </div>

                <table id="tabla-paquetes" class="table align-items-center mb-0 w-100 d-none">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Precio</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paquetes as $paquete)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-xs">{{ $paquete->nombre }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-normal mb-0">${{ number_format($paquete->precio, 2) }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    
                                        <button class="btn btn-link text-success p-0 mx-1" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarPaquete{{ $paquete->id }}">
                                            <span class="material-icons">edit</span>
                                        </button>
                                    

                                    @can('Eliminar paquetes')
                                        <button type="button" class="btn btn-link text-danger p-0 mx-1" title="Eliminar"
                                            data-bs-toggle="modal" data-bs-target="#modalEliminarPaquete{{ $paquete->id }}">
                                            <span class="material-icons">delete_forever</span>
                                        </button>
                                    @endcan

                                    <!-- Modales -->
                                    @include('paquetes.modal-edit', ['paquete' => $paquete])
                                    @include('paquetes.modal-delete', ['paquete' => $paquete])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-xs">No hay paquetes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para crear paquete -->
        @include('paquetes.modal-create')

        <!-- Alertas -->
        @include('components.alert-toast')

            @include('paquetes.partials.scripts')

    </main>
</x-layout>
