<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='rentas' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Generar Renta" />

        @include('components.alert-toast')

        @if(session('renta_id_para_imprimir'))
            <iframe id="iframeTicket"
                src="{{ route('tickets.rentas.imprimible', session('renta_id_para_imprimir')) }}"
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
                        <span class="material-icons-round me-1">search</span>
                        Buscar Cliente
                    </label>
                    <select id="busqueda_cliente" class="form-control"></select>
                    <input type="hidden" name="cliente_renta_id" id="cliente_id">
                </div>

                {{-- Datos del cliente --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Cliente</label>
                        <input type="text" id="nombre_cliente" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Día de pago</label>
                        <input type="text" id="dia_pago" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Precio de la renta</label>
                        <input type="number" id="precio" class="form-control" readonly>
                    </div>
                </div>

                {{-- Configuración --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Meses</label>
                        <select name="meses" id="meses" class="form-select" required>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Método de pago</label>
                        <select name="tipo_pago" id="tipo_pago" class="form-select" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>

                    {{-- AUMENTO --}}
                    <div class="col-md-4">
                        <label class="form-label">Aumento</label>
                        <input type="number" name="aumento" id="aumento" class="form-control" value="0">
                    </div>

                    {{-- Luz solo informativa --}}
                    <div class="col-md-4">
                        <label class="form-label">Recargo de la luz</label>
                        <input type="text" id="recargo_luz_texto" class="form-control" readonly>
                        <input type="hidden" name="recargo_luz" id="recargo_luz" value="0">
                    </div>
                </div>

                {{-- Resumen --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Subtotal</label>
                        <input type="number" id="subtotal" class="form-control" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total</label>
                        <input type="number" id="total" class="form-control" readonly>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons-round me-1">check_circle</span>
                        Generar renta
                    </button>
                </div>

            </form>
        </div>
    </main>
</x-layout>


<script>
    let recargoLuz = 0;

    $('#busqueda_cliente').select2({
        placeholder: 'Buscar cliente...',
        ajax: {
            url: '{{ route("clientes_rentas.buscar") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (cliente) {
                        return {
                            id: cliente.id,
                            text: cliente.nombre,
                            nombre: cliente.nombre,
                            dia_pago: cliente.dia_pago,
                            precio: cliente.precio
                        }
                    })
                };
            }
        }
    });

    $('#busqueda_cliente').on('select2:select', function (e) {
        let data = e.params.data;

        $('#cliente_id').val(data.id);
        $('#nombre_cliente').val(data.nombre);
        $('#dia_pago').val(data.dia_pago);
        $('#precio').val(data.precio);

        calcularTotales();
    });

    function calcularTotales() {
        let precio = parseFloat($('#precio').val()) || 0;
        let meses = parseInt($('#meses').val()) || 0;
        let aumento = parseFloat($('#aumento').val()) || 0;

        let subtotal = precio * meses;
        let total = subtotal + aumento + recargoLuz;

        $('#subtotal').val(subtotal.toFixed(2));
        $('#total').val(total.toFixed(2));
    }

    $('#meses, #aumento').on('input change', calcularTotales);

    function configurarLuz() {
        const mesActual = new Date().getMonth() + 1;

        if (mesActual % 2 !== 0) {
            recargoLuz = 200;
            $('#recargo_luz').val(200);
            $('#recargo_luz_texto').val('Incluye luz ($200)');
        } else {
            recargoLuz = 0;
            $('#recargo_luz').val(0);
            $('#recargo_luz_texto').val('No incluye luz');
        }

        calcularTotales();
    }

    configurarLuz();
</script>
