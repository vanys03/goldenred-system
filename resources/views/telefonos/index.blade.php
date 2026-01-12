<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='telefonos' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Teléfonos por marcar" />
        <!-- End Navbar -->

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Listado de Teléfonos</h5>
                    @can('Crear telefonos')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearTelefono">
                            <span class="material-icons align-middle">add</span> Agregar Teléfono
                        </button>
                    @endcan
                </div>

                <table id="tabla-telefonos" class="table align-items-center mb-0 w-100">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">ID</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Nombre</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Número</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($telefonos as $telefono)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-normal mb-0">{{ $telefono->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-normal mb-0">{{ $telefono->nombre }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-normal mb-0">{{ $telefono->numero }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-xs">{{ $telefono->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-xs">No hay teléfonos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-layout>
