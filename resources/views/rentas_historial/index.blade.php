<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='rentas_historial' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Historial de Rentas" />


        @include('components.alert-toast')


        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Historial de Rentas</h5>
                </div>

                @if($historial->count())
                    <table id="tabla-rentas-historial" class="table align-items-center mb-0 w-100 d-none">

                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th class="text-center">Meses pagados</th>
                                <th class="text-center">Recargo Luz</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Fecha Venta</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>

                    {{-- Loader --}}
                    <div id="loader-rentas-historial" class="text-center py-4">
                        <div class="spinner-border text-primary"></div>
                    </div>

                @else
                    <p class="text-muted px-3">No hay historial de rentas registrado.</p>
                @endif
            </div>

            

        </div>
        @include('rentas_historial.partials.modal-ver')
        @include('rentas_historial.partials.modal-delete')
        @include('rentas_historial.partials.scripts')

        <script>
function reimprimirTicket(rentaId) {
    let iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = `/tickets/rentas/${rentaId}/imprimible`;
    document.body.appendChild(iframe);

    iframe.onload = function () {
        iframe.contentWindow.print();
        setTimeout(() => document.body.removeChild(iframe), 2000);
    };
}
</script>

    </main>


</x-layout>