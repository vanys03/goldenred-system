@push('scripts')
<script>
    const tabla = $('#tabla-perfiles');

    if (tabla.length) {
        tabla.DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ route("account-profiles.data") }}',
            deferRender: true,
            pageLength: 10,
            columns: [
                { data: 'platform_name', name: 'platforms.name', className: 'text-center' },
                { data: 'account_email', name: 'accounts.email', className: 'text-center' },
                { data: 'profile_name', name: 'profiles.name', className: 'text-center' },
                { data: 'current_holder', name: 'profiles.current_holder', className: 'text-center' },
                { data: 'telefono', name: 'profiles.telefono', className: 'text-center' },
                { data: 'assigned_since', name: 'profiles.assigned_since', className: 'text-center' },
                { data: 'notes', name: 'profiles.notes', className: 'text-center' },
                { data: 'acciones', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            }
        });
    }
</script>
@endpush