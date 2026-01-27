<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas_corte' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Corte de ventas" />
        {{-- ================= MODAL PENDIENTES AYER + HOY ================= --}}
        @if(isset($bloquearCorte) && $bloquearCorte)
            <div class="modal fade show d-block" tabindex="-1"
                style="background: rgba(0,0,0,.7); backdrop-filter: blur(4px);">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">

                        {{-- Header --}}
                        <div class="modal-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="modal-title fw-bold text-dark d-flex align-items-center">
                                <span class="badge bg-warning text-dark me-2 p-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </span>
                                Clientes con Pagos Pendientes
                            </h5>
                        </div>

                        <div class="modal-body px-4">
                            <p class="text-muted small">
                                Marca los clientes que **sí realizaron pago por transferencia** antes de cerrar el corte.
                            </p>

                            <form method="POST" action="{{ route('ventas.pago.transferencia') }}">
                                @csrf
                                <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                                <input type="hidden" name="usuario_id" value="{{ request('usuario_id') }}">
                                <input type="hidden" name="tipo_cliente" value="{{ request('tipo_cliente') }}">

                                {{-- ================= PENDIENTES DE AYER ================= --}}
                                @if(isset($clientesPendientesAyer) && $clientesPendientesAyer->count())
                                    <h6 class="text-danger fw-bold mt-3 mb-2">
                                        <i class="fas fa-clock me-1"></i> Pendientes de AYER
                                    </h6>

                                    <div class="table-responsive mb-4">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Paquete</th>
                                                    <th class="text-center">Día de cobro</th>
                                                    <th class="text-center">¿Pagó?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientesPendientesAyer as $cliente)
                                                    <tr class="table-danger bg-opacity-25">
                                                        <td class="fw-bold">{{ $cliente->nombre }}</td>
                                                        <td>
                                                            <span class="badge bg-light text-dark border">
                                                                {{ $cliente->paquete->nombre ?? '—' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ $cliente->dia_cobro }}</td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" name="clientes[]"
                                                                value="{{ $cliente->id }}"
                                                                style="cursor:pointer; transform: scale(1.2);">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {{-- ================= PENDIENTES DE HOY ================= --}}
                                @if(isset($clientesPendientesHoy) && $clientesPendientesHoy->count())
                                    <h6 class="text-warning fw-bold mt-3 mb-2">
                                        <i class="fas fa-calendar-day me-1"></i> Pendientes de HOY
                                    </h6>

                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Paquete</th>
                                                    <th class="text-center">Precio</th>
                                                    <th class="text-center">¿Pagó?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientesPendientesHoy as $cliente)
                                                    <tr>
                                                        <td class="fw-bold">{{ $cliente->nombre }}</td>
                                                        <td>
                                                            <span class="badge bg-light text-dark border">
                                                                {{ $cliente->paquete->nombre ?? '—' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center fw-bold">
                                                            ${{ number_format($cliente->paquete->precio ?? 0, 2) }}
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" name="clientes[]"
                                                                value="{{ $cliente->id }}"
                                                                style="cursor:pointer; transform: scale(1.2);">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {{-- INFO --}}
                                <div class="alert alert-light border-0 small text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Los clientes no marcados permanecerán con estatus <strong>Pendiente</strong>.
                                </div>

                                {{-- BOTONES --}}
                                <div class="row g-2 pb-3">
                                    <div class="col-md-7">
                                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                            Registrar Pagos Seleccionados
                                        </button>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('ventas.corte.cerrar') }}"
                                            class="btn btn-link text-muted w-100 py-2">
                                            No hubo transferencias
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================= CORTE NORMAL ================= --}}
        <div class="card m-4 p-4">

            {{-- FORMULARIO DE FILTROS (SIN SUBMIT) --}}
            <form onsubmit="return false;">
                <div class="row mb-4">

                    <div class="col-md-4">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Usuario</label>
                        <select name="usuario_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Tipo de cliente</label>
                        <select name="tipo_cliente" class="form-control">
                            <option value="">Todos</option>
                            @foreach($tiposClientes as $tipo)
                                <option value="{{ $tipo }}">
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <button type="button" class="btn btn-primary w-100" id="btnFiltrar">
                    Buscar
                </button>
            </form>

            <hr>

            <h5 class="mb-3">Ventas encontradas</h5>

            {{-- TABLA --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Pago</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="tablaVentasBody">
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Usa los filtros para consultar ventas
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- TOTALES --}}
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="alert alert-success">
                        <strong>Efectivo</strong><br>
                        Ventas: <span id="conteoEfectivo">0</span><br>
                        Total: <span id="totalEfectivo">$0.00</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="alert alert-info">
                        <strong>Transferencia</strong><br>
                        Ventas: <span id="conteoTransferencia">0</span><br>
                        Total: <span id="totalTransferencia">$0.00</span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <strong>
                    Total del corte:
                    <span id="totalGeneral">$0.00</span>
                </strong>
            </div>

        </div>

    </main>

    {{-- ================= JS FILTROS AJAX ================= --}}
    <script>
        document.getElementById('btnFiltrar').addEventListener('click', filtrarCorte);

        function filtrarCorte() {
            const fecha = document.querySelector('[name="fecha"]').value;
            const usuario = document.querySelector('[name="usuario_id"]').value;
            const tipo = document.querySelector('[name="tipo_cliente"]').value;

            fetch(`{{ route('ventas.corte.filtrar') }}?fecha=${fecha}&usuario_id=${usuario}&tipo_cliente=${tipo}`)
                .then(res => res.json())
                .then(data => {
                    actualizarTabla(data.ventas);
                    actualizarTotales(data);
                });
        }

        function actualizarTabla(ventas) {
            const tbody = document.getElementById('tablaVentasBody');
            tbody.innerHTML = '';

            if (ventas.length === 0) {
                tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No se encontraron ventas
                </td>
            </tr>
        `;
                return;
            }

            ventas.forEach(v => {
                tbody.innerHTML += `
            <tr>
                <td>${v.cliente?.nombre ?? '—'}</td>
                <td>${v.cliente?.tipo ?? '—'}</td>
                <td>${v.usuario?.name ?? '—'}</td>
                <td>$${Number(v.total).toFixed(2)}</td>
                <td>${v.tipo_pago}</td>
                <td>${new Date(v.created_at).toLocaleString()}</td>
            </tr>
        `;
            });
        }

        function actualizarTotales(data) {
            document.getElementById('conteoEfectivo').innerText = data.conteoEfectivo;
            document.getElementById('totalEfectivo').innerText = `$${data.totalEfectivo.toFixed(2)}`;

            document.getElementById('conteoTransferencia').innerText = data.conteoTransferencia;
            document.getElementById('totalTransferencia').innerText = `$${data.totalTransferencia.toFixed(2)}`;

            document.getElementById('totalGeneral').innerText = `$${data.totalGeneral.toFixed(2)}`;
        }
    </script>

</x-layout>