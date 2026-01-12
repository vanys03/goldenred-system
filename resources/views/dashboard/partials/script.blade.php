
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        const opcionesDataTable = {
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            }
        };

        $(document).ready(function () {
            const tablaClientesHoy = $('#tabla-clientes-hoy');
            if (tablaClientesHoy.length) {
                tablaClientesHoy.DataTable(opcionesDataTable);
            }

            const tablaClientesAtrasados = $('#tabla-clientes-atrasados');
            if (tablaClientesAtrasados.length) {
                tablaClientesAtrasados.DataTable(opcionesDataTable);
            }
        });
    </script>
@endpush
