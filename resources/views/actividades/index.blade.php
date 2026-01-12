<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='actividades'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Actividades" />

        <div class="card m-4">

            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Registro de Actividades</h5>
                </div>



                <table id="tabla-actividades" class="table align-items-center mb-0 w-100 d-none">


                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Usuario</th>

                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">IP</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">
                                Dispositivo</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Fecha
                            </th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Hora
                                Entrada</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Hora
                                Salida</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
                {{-- Loader --}}
                <div id="loader-actividades" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

            </div>
        </div>
    </main>

    @include('actividades.partials.scripts')

</x-layout>