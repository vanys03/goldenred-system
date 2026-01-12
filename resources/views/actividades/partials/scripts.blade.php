@push('scripts')
<script>
    const tablaActividades = $('#tabla-actividades');
    if (tablaActividades.length) {
        tablaActividades.DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ route("actividades.data") }}',
            deferRender: true,
            pageLength: 10,
            columns: [
                { data: 'usuario', name: 'users.name' },
                { data: 'ip', name: 'actividades.ip' },
                { data: 'dispositivo', name: 'actividades.dispositivo' },
                { data: 'fecha', name: 'actividades.fecha' },
                { data: 'hora_entrada', name: 'actividades.hora_entrada' },
                { data: 'hora_salida', name: 'actividades.hora_salida' }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            initComplete: function () {
                $('#loader-actividades').remove();
                tablaActividades.removeClass('d-none');
            }
        });
    }
</script>
@endpush
