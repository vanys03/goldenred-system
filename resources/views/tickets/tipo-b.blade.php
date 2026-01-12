<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ticket</title>
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

  <div class="bold">
  <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo"
     style="width: 150px; filter: contrast(150%) brightness(90%);">
</div>

  <div>Calle Morelos 63</div>
  <div>Av. Reforma 34 Cliente tipo b</div>

  <div class="line"></div>

  <div class="bold">Datos de Soporte</div>
  <div>227-201-97-71</div>
  <div>227-119-36-24</div>
  <div>227-115-69-02</div>
  <div>Horario:</div>
  <div>8:00 a.m - 10:00 p.m</div>
  <div class="bold">Depósitos o </div>
  <div class="bold"> transferencias:</div>
  <div>Oxxo:</div>
  <DIV>4217 4700 6524 0505</DIV>
  <div>Bancomer: </div>
  <div>4152 3143 8636 6150</div>
  <div>Bancoppel:</div>
  <div> 4169 1608 2132 2659</div>

  <div class="line"></div>

  <div class="bold">Datos del Ticket</div>
  <div>Vendedor: </div>
  <div>{{ explode(' ', $venta->usuario->name)[0] ?? '---' }}</div>
  <div>ID Ticket: {{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</div>
  <div>Fecha: {{ $venta->created_at->translatedFormat('d F Y H:i') }}</div>
  <div>Vencimiento: </div>
  <div>{{ $venta->periodo_fin->translatedFormat('F Y') }}</div>
  <div>Método de pago: </div>
  <div>{{ $venta->tipo_pago }}</div>

  <div class="line"></div>

  <div class="bold">Datos del Cliente</div>
  <div>Nombre: </div>
  <div>{{ $venta->cliente->nombre }}</div>
  <div>Paquete: </div>
  <div>{{ $venta->cliente->paquete->nombre ?? 'Sin paquete' }}</div>
  <div>Precio: ${{ number_format($venta->cliente->paquete->precio ?? 0, 2) }}</div>

  <div class="line"></div>

  <div class="bold">Detalle de Cobros</div>
  <div>Meses pagados: {{ $venta->meses }} mes{{ $venta->meses > 1 ? 'es' : '' }}</div>
  @if ($venta->meses == 6)
    <div>Promoción aplicada:</div>
    <div>1 mes gratis</div>
    <div>de servicio</div>
  @elseif ($venta->meses == 12)
    <div>Promoción aplicada: 2 meses de servicio gratis</div>
  @else
    <div>Sin promoción </div>
  @endif

  <div>Subtotal: ${{ number_format($venta->subtotal, 2) }}</div>
  <div>Recargo por atraso:</div>
  <div> ${{ number_format($venta->recargo_atraso ?? 0, 2) }}</div>
  <div>Cobro a Domicilio:</div>
  <div> ${{ number_format($venta->recargo_domicilio ?? 0, 2) }}</div>
  <div>Descuento: -${{ number_format($venta->descuento ?? 0, 2) }}</div>

  <div class="bold">Total a pagar: </div>
  <div>${{ number_format($venta->total, 2) }}</div>

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