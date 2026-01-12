@push('scripts')
<script>
$(document).ready(function () {

    const tablaRentas = $('#tabla-rentas-historial');

    if (tablaRentas.length) {
        tablaRentas.DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ route("rentas_historial.data") }}',
            pageLength: 10,
            deferRender: true,

            columns: [
                { data: 'cliente', name: 'clientes_rentas.nombre' },
                { data: 'usuario', name: 'users.name' },
                { data: 'meses', className: 'text-center', orderable: false },
                { data: 'recargo', className: 'text-center', orderable: false, searchable: false },
                { data: 'total', className: 'text-center' },
                { data: 'fecha_venta', className: 'text-center' },
                { data: 'acciones', orderable: false, searchable: false }
            ],

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },

            initComplete: function () {
                $('#loader-rentas-historial').remove();
                tablaRentas.removeClass('d-none');
            }
        });
    }

    // ================================
    // VER RENTA (MODAL GLOBAL)
    // ================================
    $(document).on('click', '.ver-renta', function () {

        const rentaId = $(this).data('id');

        // Mostrar modal
        $('#modalVerRenta').modal('show');

        // Loader mientras carga
        $('#contenido-ver-renta').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
            </div>
        `);

        // Ocultar botón imprimir
        $('#btnReimprimirTicket').addClass('d-none');

        // Cargar detalle por AJAX
        $('#contenido-ver-renta').load(`/rentas/${rentaId}/detalle`, function () {

            // Mostrar botón imprimir y asignar acción
            $('#btnReimprimirTicket')
                .removeClass('d-none')
                .attr('onclick', `reimprimirTicket(${rentaId})`);
        });
    });


    // ================================
// ELIMINAR RENTA (MODAL GLOBAL)
// ================================
$(document).on('click', '.eliminar-renta', function () {

    const rentaId = $(this).data('id');

    $('#formEliminarRenta')
        .attr('action', `/rentas/${rentaId}`);

    $('#texto-eliminar-renta').text(
        '¿Estás seguro de que deseas eliminar esta renta?'
    );

    $('#modalEliminarRenta').modal('show');
});


});
</script>
@endpush
