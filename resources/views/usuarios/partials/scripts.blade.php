@push('scripts')
<script>
    const tablaUsuarios = $('#tabla-usuarios');
    if (tablaUsuarios.length) {
        tablaUsuarios.DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: 3 }
            ],
            initComplete: function () {
                tablaUsuarios.removeClass('d-none');
            }
        });
    }
</script>
@endpush
