@push('scripts')
<script>
    const tablaClientes = $('#tabla-clientes');
    if (tablaClientes.length) {
        tablaClientes.DataTable({
            pageLength: 10,
            deferRender: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
            order: [],
            initComplete: function () {
                $('#loader-clientes').remove();
                tablaClientes.removeClass('d-none');
            }
        });
    }
</script>
@endpush
