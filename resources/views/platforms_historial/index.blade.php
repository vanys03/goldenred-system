<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='platforms_historial' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Historial de plataformas" />
        <!-- End Navbar -->

        <div class="card m-4">
            <div class="table-responsive p-3">
                <table id="tabla-historial" class="table align-items-center mb-0 w-100 text-xs">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Plataforma</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cuenta</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Perfil</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Teléfono</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Inicio</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Fin</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @include('platforms_historial.partials.scripts')
</x-layout>
