@push('scripts')
<script>
    const tablaHistorial = $('#tabla-historial');

    if (tablaHistorial.length) {
        tablaHistorial.DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ route("platforms_historial.data") }}',
            deferRender: true,
            pageLength: 10,
            columns: [
                { data: 'platform_name', name: 'platforms.name', className: 'text-center' },
                { data: 'account_email', name: 'accounts.email', className: 'text-center' },
                { data: 'profile_name', name: 'profiles.name', className: 'text-center' },
                { data: 'customer_name', name: 'profile_assignments.customer_name', className: 'text-center' },
                { data: 'telefono', name: 'profile_assignments.telefono', className: 'text-center' },
                { data: 'started_at', name: 'profile_assignments.started_at', className: 'text-center' },
                { data: 'ended_at', name: 'profile_assignments.ended_at', className: 'text-center' },
                { data: 'vendedor', name: 'users.name', className: 'text-center' }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            }
        });
    }
</script>
@endpush
