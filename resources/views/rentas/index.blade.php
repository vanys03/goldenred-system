<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='rentas' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Generar Renta" />

        @include('components.alert-toast')
        @if(session('renta_id_para_imprimir'))
            <iframe id="iframeTicket" src="{{ route('tickets.rentas.imprimible', session('renta_id_para_imprimir')) }}"
                style="display:none;"></iframe>
            <script>
                document.getElementById('iframeTicket').onload = function () {
                    this.contentWindow.print();
                };
            </script>
        @endif

        <div class="card m-4 p-4">
            <h5>Generar Renta</h5>

            <form id="formCrearRenta"
                action="{{ isset($rentaEditar) ? route('rentas.update', $rentaEditar->id) : route('rentas.store') }}"
                method="POST">
                @csrf

                @if(isset($rentaEditar))
                    @method('PUT')
                @endif

                {{-- Buscar Cliente --}}
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">
                        <span class="material-icons-round align-middle me-1">search</span> Buscar Cliente
                    </label>
                    <select id="busqueda_cliente" class="form-control border rounded-2"></select>
                    <small id="estadoCliente" class="text-muted d-block mt-1"></small>
                    <input type="hidden" name="cliente_renta_id" id="cliente_id">
                </div>

                <div id="datosCliente" class="border-top pt-3">
                    {{-- Información Cliente --}}
                    @if(isset($rentaEditar))
                        <div class="d-flex justify-content-between align-items-center alert alert-warning mb-3">
                            <div>
                                <span class="material-icons-round me-2 align-middle">edit_note</span>
                                Estás editando una renta existente.
                            </div>
                            <a href="{{ route('rentas.index') }}" class="btn btn-sm btn-outline-secondary">
                                <span class="material-icons-round align-middle me-1">undo</span> Cancelar edición
                            </a>
                        </div>
                    @endif

                    {{-- Configuración Renta --}}

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                <span class="material-icons-round align-middle me-1">person</span> Cliente
                            </label>
                            <input type="text" id="nombre_cliente" class="form-control border rounded-2 px-2" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <span class="material-icons-round align-middle me-1">event</span> Día de Pago
                            </label>
                            <input type="text" id="dia_pago" class="form-control border rounded-2 px-2" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Precio de la Renta</label>
                            <input type="number" id="precio" class="form-control border rounded-2 px-2" readonly>
                        </div>
                    </div>



                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Meses</label>
                            <select name="meses" id="meses" class="form-select border rounded-2 px-2" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_pago" class="form-label">Método de Pago</label>
                            <select name="tipo_pago" id="tipo_pago" class="form-select" required>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label">Descuento</label>
                            <input type="number" name="descuento" id="descuento"
                                class="form-control border rounded-2 px-2" value="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Recargo de la luz</label>
                            <input type="number" name="recargo_domicilio" id="recargo_domicilio"
                                class="form-control border rounded-2 px-2" value="0">
                        </div>
                    </div>

                    {{-- Resumen --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Subtotal</label>
                            <input type="number" name="subtotal" id="subtotal"
                                class="form-control border rounded-2 px-2" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total</label>
                            <input type="number" name="total" id="total" class="form-control border rounded-2 px-2"
                                readonly>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" id="btnConfirmarRenta" class="btn btn-primary">
                            <span class="material-icons-round align-middle me-1">check_circle</span>
                            Generar Renta
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </main>
    @include('rentas.partials.scripts')
</x-layout>


<script>$('#busqueda_cliente').select2({
        placeholder: 'Buscar cliente...',
        ajax: {
            url: '{{ route("clientes_rentas.buscar") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (cliente) {
                        return {
                            id: cliente.id,
                            text: cliente.nombre, // lo que se muestra en el dropdown
                            nombre: cliente.nombre,
                            dia_pago: cliente.dia_pago,
                            telefono1: cliente.telefono1,
                            direccion: cliente.direccion,
                            precio: cliente.precio
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Cuando seleccionas un cliente, llenamos los divs
    $('#busqueda_cliente').on('select2:select', function (e) {
        var data = e.params.data;

        // Guardamos el id en el hidden
        $('#cliente_id').val(data.id);

        // Mostramos nombre y día de pago en los divs
        $('#nombre_cliente').val(data.nombre); // si es input
        $('#dia_pago').val(data.dia_pago);
        $('#precio').val(data.precio);
    });


    function calcularTotales() {
        let precio = parseFloat($('#precio').val()) || 0;
        let meses = parseInt($('#meses').val()) || 0;
        let descuento = parseFloat($('#descuento').val()) || 0;
        let recargo = parseFloat($('#recargo_domicilio').val()) || 0;

        // Calcular subtotal y total
        let subtotal = precio * meses;
        let total = subtotal - descuento + recargo;

        // Mostrar en los inputs
        $('#subtotal').val(subtotal.toFixed(2));
        $('#total').val(total.toFixed(2));
    }

    // Ejecutar cálculo cada vez que cambie un campo
    $('#meses, #descuento, #recargo_domicilio').on('input change', calcularTotales);

    // También recalcular cuando se seleccione un cliente (porque se carga el precio)
    $('#busqueda_cliente').on('select2:select', function () {
        calcularTotales();
    });

</script>