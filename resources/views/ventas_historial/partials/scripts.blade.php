<script>
    let ventaIdActual = null;

    // Evento al hacer clic en los botones de ver venta
    document.querySelectorAll('.btn-ver-venta').forEach(btn => {
        btn.addEventListener('click', function () {
            ventaIdActual = this.dataset.id;

            fetch(`/api/ventas/${ventaIdActual}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error de red');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detalle_cliente').textContent = data.cliente ?? '—';
                    document.getElementById('detalle_paquete').textContent = data.paquete ?? '—';
                    document.getElementById('detalle_meses').textContent = data.meses ?? '—';
                    document.getElementById('detalle_descuento').textContent = `$${data.descuento ?? '0.00'}`;
                    document.getElementById('detalle_recargo_domicilio').textContent = `$${data.recargo_domicilio ?? '0.00'}`;
                    document.getElementById('detalle_recargo_atraso').textContent = `$${data.recargo_atraso ?? '0.00'}`;


                    document.getElementById('detalle_total').textContent = `$${data.total ?? '0.00'}`;

                    const modal = new bootstrap.Modal(document.getElementById('modalDetalleVenta'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error al cargar la venta:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        });
    });

    // Evento para el botón de reimprimir ticket
    document.getElementById('btnReimprimirTicket').addEventListener('click', function () {
        if (ventaIdActual) {
            // Elimina si ya hay un iframe anterior
            document.querySelectorAll('.iframe-impresion-ticket').forEach(el => el.remove());

            // Crea uno nuevo
            const iframe = document.createElement('iframe');
            iframe.src = `/ventas/${ventaIdActual}/ticket`;
            iframe.className = 'iframe-impresion-ticket';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';
            iframe.style.visibility = 'hidden';

            document.body.appendChild(iframe);

        } else {
            alert('Primero selecciona una venta válida.');
        }
    });

    // Limpieza de fondo al cerrar modal
    document.getElementById('modalDetalleVenta').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        document.body.style = '';
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
    });
</script>
<script>
    document.querySelectorAll('.btn-modalEliminarVenta').forEach(btn => {
        btn.addEventListener('click', function () {
            const ventaId = this.dataset.id;
            const clienteNombre = this.dataset.cliente;

            // Actualiza nombre en el texto del modal
            document.getElementById('nombreClienteEliminar').textContent = clienteNombre;

            // Actualiza la acción del formulario para eliminar correctamente
            const form = document.getElementById('formEliminarVenta');
            form.action = `/ventas/${ventaId}`; // o usa route() si lo armas con Blade

            // Muestra la modal
            const modal = new bootstrap.Modal(document.getElementById('modalEliminarVenta'));
            modal.show();
        });
    });
</script>


@push('scripts')
    <script>
        const tablaVentas = $('#tabla-ventas');
        if (tablaVentas.length) {
            tablaVentas.DataTable({
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                },
                columnDefs: [
                    { orderable: false, targets: 4 }
                ],
                initComplete: function () {
                    tablaVentas.removeClass('d-none');
                }
            });
        }
    </script>
@endpush


<script>

    function formatFechaLocal(date) {
        const year = date.getFullYear();
        const mes = String(date.getMonth() + 1).padStart(2, '0');
        const dia = String(date.getDate()).padStart(2, '0');
        return `${year}-${mes}-${dia}`;
    }

    function seleccionarHoy() {
    const hoy = new Date();
    const fecha = formatFechaLocal(hoy);
    document.getElementById('fecha_inicio').value = fecha;
    document.getElementById('fecha_fin').value = fecha;
}


    function seleccionarSemana() {
    const hoy = new Date();
    const diaSemana = hoy.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado

    // Calcular lunes
    const lunes = new Date(hoy);
    lunes.setDate(hoy.getDate() - (diaSemana === 0 ? 6 : diaSemana - 1));

    // Calcular domingo
    const domingo = new Date(lunes);
    domingo.setDate(lunes.getDate() + 6);

    document.getElementById('fecha_inicio').value = formatFechaLocal(lunes);
    document.getElementById('fecha_fin').value = formatFechaLocal(domingo);
}



   function seleccionarMes() {
    const hoy = new Date();
    const primerDia = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    const ultimoDia = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);

    document.getElementById('fecha_inicio').value = formatFechaLocal(primerDia);
    document.getElementById('fecha_fin').value = formatFechaLocal(ultimoDia);
}

</script>