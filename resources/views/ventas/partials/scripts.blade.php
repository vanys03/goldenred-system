<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#busqueda_cliente').select2({
            placeholder: 'Buscar cliente...',
            width: '100%',
            ajax: {
                url: '/ventas/buscar-clientes',
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: data => ({ results: data.results }),
                cache: true
            }
        });

        $('#busqueda_cliente').on('select2:select', function (e) {
            const data = e.params.data;
            const clienteId = data.id;

            $(this).select2('close');

            $('#cliente_id').val(clienteId);
            $('#nombre_cliente').val(data.text);
            $('#nombre_paquete').val(data.paquete.nombre);
            $('#precio_paquete').val(data.paquete.precio);
            $('#dia_pago').val(data.dia_pago);
            // Mostrar tipo de cliente como badge
            const tipo = data.tipo || 'C'; // fallback por si no viene

            let badgeColor = 'secondary';
            let badgeLabel = 'Tipo C';

            if (tipo === 'A') {
                badgeColor = 'danger';
                badgeLabel = 'Tipo A';
            } else if (tipo === 'B') {
                badgeColor = 'warning';
                badgeLabel = 'Tipo B';
            }

            $('#tipo_cliente_badge').html(`
    <span class="badge bg-${badgeColor} text-white text-xs">${badgeLabel}</span>
`);



            $('#meses').val(1);
            $('#descuento').val(0);
            $('#recargo_domicilio').val(0);
            $('#recargo_falta_pago').val(0);


            const info = $('#info_falta_pago');
            info.hide().removeClass('text-danger text-success').text('');

            $('#datosCliente').removeClass('d-none');

            obtenerRecargoReal(clienteId);
            calcularTotal();

            fetch(`/ventas/estado-cliente/${clienteId}`)
                .then(res => res.json())
                .then(data => {
                    const estadoDiv = $('#estadoCliente');
                    estadoDiv
                        .hide()
                        .removeClass('text-success text-warning text-danger')
                        .addClass('d-block');

                    let colorClass = 'text-muted';
                    if (data.estado === 'corriente') colorClass = 'text-success';
                    else if (data.estado === 'proximo') colorClass = 'text-warning';
                    else if (data.estado === 'atrasado') colorClass = 'text-danger';

                    estadoDiv
                        .attr('class', 'text-sm mt-1 ' + colorClass)
                        .text(data.mensaje)
                        .fadeIn(300);
                });
        });

        ['meses', 'descuento', 'recargo_domicilio', 'recargo_falta_pago'].forEach(id => {
            document.getElementById(id).addEventListener('input', calcularTotal);
        });

        function calcularTotal() {
            const precio = parseFloat($('#precio_paquete').val()) || 0;
            const meses = parseInt($('#meses').val()) || 1;
            const descuento = parseFloat($('#descuento').val()) || 0;
            const domicilio = parseFloat($('#recargo_domicilio').val()) || 0;
            const falta = parseFloat($('#recargo_falta_pago').val()) || 0;

            const subtotal = precio * meses;
            $('#subtotal').val(subtotal.toFixed(2));
            const total = subtotal - descuento + domicilio + falta;
            $('#total').val(total.toFixed(2));
        }

        function obtenerRecargoReal(clienteId) {
            fetch(`/ventas/recargo/${clienteId}`)
                .then(res => res.json())
                .then(data => {
                    $('#recargo_falta_pago').val(data.recargo.toFixed(2));

                    const info = $('#info_falta_pago');
                    info
                        .hide()
                        .removeClass('text-danger text-success');

                    let mensaje = '';
                    let clase = 'text-muted';

                    if (data.dias_atraso === 0) {
                        mensaje = 'Oportuno';
                        clase = 'text-success';
                    } else if (data.dias_atraso >= 1 && data.dias_atraso <= 3) {
                        mensaje = `Normal (${data.dias_atraso}d)`;
                        clase = 'text-warning';
                    } else {
                        mensaje = `Con corte (${data.dias_atraso}d)`;
                        clase = 'text-danger';
                    }

                    info
                        .hide()
                        .removeClass('text-success text-warning text-danger text-muted')
                        .addClass(clase)
                        .text(mensaje)
                        .fadeIn(300);


                    info.fadeIn(300);

                    calcularTotal();
                });
        }

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnConfirmar = document.getElementById('btnConfirmarVenta');
        const btnEnviar = document.getElementById('btnEnviarFormulario');

        btnConfirmar.addEventListener('click', function () {
            const clienteId = document.getElementById('cliente_id').value;
            const tipoPago = document.getElementById('tipo_pago').value;
            const meses = document.getElementById('meses').value;

            if (!clienteId || !tipoPago || !meses) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Faltan datos',
                    text: 'Por favor, complete todos los campos obligatorios antes de continuar.',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Obtener valores
            const cliente = document.getElementById('nombre_cliente').value || 'N/A';
            const paquete = document.getElementById('nombre_paquete').value || 'N/A';
            const descuento = parseFloat(document.getElementById('descuento').value || 0).toFixed(2);
            const recargoDomicilio = parseFloat(document.getElementById('recargo_domicilio').value || 0).toFixed(2);
            const recargoFaltaPago = parseFloat(document.getElementById('recargo_falta_pago').value || 0).toFixed(2);
            const total = parseFloat(document.getElementById('total').value || 0).toFixed(2);

            // Colocar en el resumen
            document.getElementById('resumen_cliente').textContent = cliente;
            document.getElementById('resumen_paquete').textContent = paquete;
            document.getElementById('resumen_meses').textContent = meses;
            document.getElementById('resumen_descuento').textContent = descuento;
            document.getElementById('resumen_tipo_pago').textContent = tipoPago;
            document.getElementById('resumen_recargo_domicilio').textContent = recargoDomicilio;
            document.getElementById('resumen_recargo_falta_pago').textContent = recargoFaltaPago;
            document.getElementById('resumen_total').textContent = total;

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalConfirmarVenta'));
            modal.show();
        });

        btnEnviar.addEventListener('click', function () {
            // Desactivar el botón inmediatamente
            this.disabled = true;

            // Cambiar texto o icono si deseas retroalimentación visual
            this.innerHTML = '<i class="material-icons me-1">hourglass_top</i> Procesando...';

            // Enviar el formulario
            document.getElementById('formCrearVenta').submit();
        });

    });
</script>
@if($ventaEditar)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#cliente_id').val({{ $ventaEditar->cliente->id }});
            $('#nombre_cliente').val(@json($ventaEditar->cliente->nombre));
            $('#nombre_paquete').val(@json($ventaEditar->cliente->paquete->nombre ?? 'Sin paquete'));
            $('#precio_paquete').val({{ $ventaEditar->cliente->paquete->precio ?? 0 }});
            $('#meses').val({{ $ventaEditar->meses }});
            $('#tipo_pago').val(@json($ventaEditar->tipo_pago));
            $('#descuento').val({{ $ventaEditar->descuento }});
            $('#recargo_domicilio').val({{ $ventaEditar->recargo_domicilio }});
            $('#recargo_falta_pago').val({{ $ventaEditar->recargo_falta_pago ?? 0 }});
            $('#dia_pago').val({{ $ventaEditar->cliente->dia_cobro ?? 1 }});

            $('#datosCliente').removeClass('d-none');

            calcularTotal();
        });
    </script>
@endif