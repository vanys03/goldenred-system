@push('scripts')
<script>
    const tablaPaquetes = $('#tabla-paquetes');
    if (tablaPaquetes.length) {
        tablaPaquetes.DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: 2 }
            ],
            order: [],
            initComplete: function () {
                tablaPaquetes.removeClass('d-none');
            }
        });
    }
</script>
@endpush
