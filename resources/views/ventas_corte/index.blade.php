<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas_corte' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Corte de ventas" />

        <div class="card m-4 p-4">
            <form method="GET" action="{{ route('ventas.corte') }}">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" 
                               value="{{ request('fecha') ?? now()->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="usuario_id">Usuario:</label>
                        <select name="usuario_id" id="usuario_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" 
                                    {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="tipo_cliente">Tipo de cliente:</label>
                        <select name="tipo_cliente" id="tipo_cliente" class="form-control">
                            <option value="">Todos</option>
                            @foreach($tiposClientes as $tipo)
                                <option value="{{ $tipo }}" 
                                    {{ request('tipo_cliente') == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Buscar</button>
                    </div>
                </div>
            </form>

            @isset($ventas)
                <hr>
                <h5>Ventas encontradas: {{ $ventas->count() }}</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Tipo de pago</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td>{{ $venta->cliente->nombre ?? '—' }}</td>
                                <td>{{ $venta->cliente->tipo ?? '—' }}</td>
                                <td>{{ $venta->usuario->name ?? '—' }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td>{{ $venta->tipo_pago }}</td>
                                <td>{{ $venta->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="alert alert-success">
                            <strong>Efectivo</strong><br>
                            Ventas: {{ $conteoEfectivo }} <br>
                            Total: ${{ number_format($totalEfectivo, 2) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <strong>Transferencia</strong><br>
                            Ventas: {{ $conteoTransferencia }} <br>
                            Total: ${{ number_format($totalTransferencia, 2) }}
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <strong>Total del corte: ${{ number_format($ventas->sum('total'), 2) }}</strong>
                </div>
            @endisset
        </div>
    </main>
</x-layout>
