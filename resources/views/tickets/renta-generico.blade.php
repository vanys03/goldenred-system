<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ticket Renta</title>

    <style>
    @media print {
      @page {
        size: 48mm auto;
        margin: 0;
      }

      html,
      body {
        margin: 0;
        padding: 0;
        width: 100%;
      }

      body {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.4;
        text-align: left;
        padding-left: 12px;
        padding-right: 4px;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal;
      }
    }

    body {
      margin: 0;
      padding: 2px 12px;
      color: #000;
      font-family: 'Courier New', monospace;
      font-size: 14px;
      line-height: 1.4;
      text-align: left;
    }

    .bold {
      font-weight: bold;
    }

    .line {
      border-top: 1px dashed #999;
      margin: 6px 0;
    }
  </style>
</head>

@php
  use Carbon\Carbon;

  $fechaRenta = Carbon::parse($renta->fecha_venta);
  $mesPagado = ucfirst($fechaRenta->translatedFormat('F Y'));
  $incluyeLuz = $fechaRenta->month % 2 !== 0;
@endphp

<body onload="window.print();">

<!-- ENCABEZADO -->
<div>
  <img src="{{ asset('assets/img/logo1.png') }}" style="width:140px">
  <div class="bold">RECIBO DE PAGO DE RENTA</div>
</div>

<div>
  Calle Morelos 63<br>
  Av. Reforma 34
</div>

<div class="line"></div>

<!-- DATOS DEL PAGO -->
<div class="bold">Datos del Pago</div>
<div>Ticket: {{ str_pad($renta->id, 5, '0', STR_PAD_LEFT) }}</div>
<div>Fecha: {{ $fechaRenta->format('d/m/Y H:i') }}</div>
<div>Método: {{ $renta->tipo_pago }}</div>
<div>Cajero: {{ explode(' ', $renta->usuario->name)[0] ?? '---' }}</div>

<div class="line"></div>

<!-- ARRENDATARIO -->
<div class="bold">Arrendatario</div>
<div>{{ $renta->cliente->nombre ?? 'N/A' }}</div>
<div>{{ $renta->cliente->direccion ?? '---' }}</div>

<div class="line"></div>

<!-- CONCEPTO -->
<div class="bold">Concepto del Pago</div>
<div>Renta mensual</div>
<div>Mes que se paga:</div>
<div>{{ $mesPagado }}</div>

<div class="line"></div>

<!-- DESGLOSE -->
<div>Subtotal renta: ${{ number_format($renta->subtotal, 2) }}</div>

@if(($renta->aumento ?? 0) > 0)
  <div>Aumento: ${{ number_format($renta->aumento, 2) }}</div>
@endif

<div>
  Luz:
  @if($incluyeLuz)
    Incluida (${{ number_format($renta->recargo_domicilio ?? 0, 2) }})
  @else
    No incluida
  @endif
</div>

<div class="line"></div>

<!-- TOTAL -->
<div>
  TOTAL PAGADO<br>
  ${{ number_format($renta->total, 2) }}
</div>

<div class="line"></div>

<!-- PIE -->
<div>
  Pago recibido conforme.<br>
  Este ticket sirve como comprobante.<br><br>
  ¡Gracias por su preferencia!
</div>

<script>
window.addEventListener('load', () => {
  window.print();
  setTimeout(() => window.close(), 800);
});
</script>

</body>
</html>
