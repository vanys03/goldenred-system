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

<body onload="window.print();">

  <!-- Logo -->
  <div class="bold">
    <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo"
         style="width: 150px; filter: contrast(150%) brightness(90%);">
  </div>

  <div>Calle Morelos 63</div>
  <div>Av. Reforma 34</div>
  <div>Ticket de renta</div>

  <div class="line"></div>

  <!-- Datos de soporte -->
  <div class="bold">Datos de Soporte</div>
  <div>227-201-97-71</div>
  <div>227-119-36-24</div>
  <div>227-115-69-02</div>
  <div>Horario:</div>
  <div>8:00 a.m - 10:00 p.m</div>
  <div class="bold">Depósitos o transferencias:</div>
  <div>Oxxo: 4217 4700 6524 0505</div>
  <div>Bancomer: 4152 3143 8636 6150</div>
  <div>Bancoppel: 4169 1608 2132 2659</div>

  <div class="line"></div>

  <!-- Datos del Ticket -->
  <div class="bold">Datos del Ticket</div>
  <div>Vendedor:</div>
  <div>{{ explode(' ', $renta->usuario->name)[0] ?? '---' }}</div>
  <div>ID Ticket: {{ str_pad($renta->id, 5, '0', STR_PAD_LEFT) }}</div>
  <div>Fecha: {{ \Carbon\Carbon::parse($renta->fecha_venta)->translatedFormat('d F Y H:i') }}</div>
  <div>Método de pago: {{ $renta->tipo_pago }}</div>

  <div class="line"></div>

  <!-- Datos del Cliente -->
  <div class="bold">Datos del Cliente</div>
  <div>Nombre:</div>
  <div>{{ $renta->cliente->nombre ?? 'N/A' }}</div>
  <div>Dirección:</div>
  <div>{{ $renta->cliente->direccion ?? '---' }}</div>
  <div>Día de pago: {{ $renta->cliente->dia_pago ?? '---' }}</div>
  <div>Precio mensual: ${{ number_format($renta->cliente->precio ?? 0, 2) }}</div>

  <div class="line"></div>

  <!-- Detalle de Cobros -->
  <div class="bold">Detalle de Cobros</div>
  <div>Meses pagados: {{ $renta->meses }} mes{{ $renta->meses > 1 ? 'es' : '' }}</div>
  <div>Subtotal: ${{ number_format($renta->subtotal, 2) }}</div>
  <div>Descuento: -${{ number_format($renta->descuento ?? 0, 2) }}</div>
  <div>Recargo Luz: ${{ number_format($renta->recargo_domicilio ?? 0, 2) }}</div>

  <div class="bold">Total a pagar:</div>
  <div>${{ number_format($renta->total, 2) }}</div>

  <div class="line"></div>

  <div style="font-size: 11px;">¡Gracias por tu preferencia!</div>

  <script>
    window.addEventListener('load', function () {
        window.print();
        setTimeout(() => window.close(), 1000); // opcional: cierra la ventana tras imprimir
    });
  </script>

</body>
</html>
