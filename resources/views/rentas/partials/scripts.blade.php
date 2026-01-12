
<script>
    $('#busqueda_cliente').select2({
    placeholder: 'Buscar cliente...',
    ajax: {
        url: '{{ route("clientes_rentas.buscar") }}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term // término de búsqueda
            };
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (cliente) {
                    return {
                        id: cliente.id,
                        text: cliente.nombre + ' - ' + cliente.email
                    }
                })
            };
        },
        cache: true
    }
});

// Cuando seleccionas un cliente, guardamos el id en el hidden
$('#busqueda_cliente').on('select2:select', function (e) {
    var data = e.params.data;
    $('#cliente_id').val(data.id);
});

    
</script>