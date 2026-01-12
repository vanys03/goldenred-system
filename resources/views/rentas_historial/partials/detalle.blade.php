<div class="row g-3">

    <div class="col-md-6">
        <p class="fw-bold mb-1">Cliente:</p>
        <p class="text-muted">{{ $renta->cliente->nombre ?? 'N/A' }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Usuario:</p>
        <p class="text-muted">{{ $renta->usuario->name ?? 'N/A' }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Meses pagados:</p>
        <p class="text-muted">{{ $renta->meses }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Método de Pago:</p>
        <p class="text-muted">{{ $renta->tipo_pago }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Descuento:</p>
        <p class="text-muted">${{ number_format($renta->descuento, 2) }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Recargo Luz:</p>
        <p class="text-muted">${{ number_format($renta->recargo_domicilio, 2) }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Subtotal:</p>
        <p class="text-muted">${{ number_format($renta->subtotal, 2) }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Total:</p>
        <p class="text-muted fw-bold">${{ number_format($renta->total, 2) }}</p>
    </div>

    <div class="col-md-6">
        <p class="fw-bold mb-1">Fecha Venta:</p>
        <p class="text-muted">
            {{ \Carbon\Carbon::parse($renta->fecha_venta)->format('d/m/Y') }}
        </p>
    </div>

</div>
