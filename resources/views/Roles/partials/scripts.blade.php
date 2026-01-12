@push('scripts')
<script>
    const tablaRoles = $('#tabla-roles');
    if (tablaRoles.length) {
        tablaRoles.DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: 2 }
            ],
            order: [],
            initComplete: function () {
                tablaRoles.removeClass('d-none');
            }
        });
    }
</script>
@endpush
