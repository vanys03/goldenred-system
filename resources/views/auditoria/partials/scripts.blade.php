@push('scripts')
<script>
    const tablaAuditoria = $('#tabla-auditoria');
    if (tablaAuditoria.length) {
        tablaAuditoria.DataTable({
            pageLength: 10,
            deferRender: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: 3 } // ← la columna de Detalle no se ordena
            ],
            order: [],
            initComplete: function () {
                $('#loader-auditoria').remove();
                tablaAuditoria.removeClass('d-none');
            }
        });
    }
</script>
@endpush
