<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::with([
            'paquete',
            'ventas' => fn($q) => $q->orderBy('fecha_venta', 'desc')->limit(1)
        ])->get();

        $ventasHoy = Venta::with(['cliente', 'usuario'])
            ->whereDate('fecha_venta', today())
            ->orderBy('created_at', 'desc')
            ->get();

        $ventaEditar = null;
        if ($request->has('editar')) {
            $ventaEditar = Venta::with('cliente.paquete')->find($request->editar);
        }

        return view('ventas.index', compact('clientes', 'ventasHoy', 'ventaEditar'));
    }


    public function calcularRecargo(Cliente $cliente)
    {
        [$diasAtraso, $recargo_falta_pago] = $this->obtenerAtrasoYRecargo($cliente);

        return response()->json([
            'recargo' => $recargo_falta_pago,
            'dias_atraso' => $diasAtraso,
        ]);
    }

    public function buscarClientes(Request $request)
    {
        $search = $request->input('q');

        $clientes = Cliente::with('paquete')
            ->where('nombre', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        $resultados = $clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'text' => $cliente->nombre,
                'tipo' => $cliente->tipo,
                'dia_pago' => $cliente->dia_cobro,
                'paquete' => [
                    'nombre' => $cliente->paquete->nombre ?? 'Sin paquete',
                    'precio' => $cliente->paquete->precio ?? 0,
                ],
            ];
        });

        return response()->json(['results' => $resultados]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'meses' => 'required|integer|min:1|max:12',
            'descuento' => 'nullable|numeric|min:0',
            'recargo_domicilio' => 'nullable|numeric|min:0',
            'tipo_pago' => 'required|in:Efectivo,Transferencia',
        ]);

        $minutosBloqueo = 5;

        $ventaReciente = Venta::where('cliente_id', $request->cliente_id)
            ->where('created_at', '>=', now()->subMinutes($minutosBloqueo))
            ->exists();

        if ($ventaReciente) {
            return redirect()->back()->with(
                'error',
                'Este cliente ya tiene un pago registrado recientemente. Espera unos minutos para volver a intentar.'
            );
        }

        $cliente = Cliente::with('paquete')->findOrFail($request->cliente_id);

        if (!$cliente->paquete) {
            return redirect()->back()->with(
                'error',
                'Este cliente no tiene paquete asignado.'
            );
        }
        $precioPaquete = $cliente->paquete->precio;
        $meses = (int) $request->meses;

        $mesesExtra = 0;
        if ($meses === 6) {
            $mesesExtra = 1;
        } elseif ($meses === 12) {
            $mesesExtra = 2;
        }

        $mesesTotales = $meses + $mesesExtra;
        $subtotal = $precioPaquete * $meses;
        $ultimaVenta = Venta::where('cliente_id', $cliente->id)
            ->orderBy('fecha_venta', 'desc')
            ->first();

        [$diasAtraso, $recargoCalculado] = $this->obtenerAtrasoYRecargo($cliente);

        $total = $subtotal
            - ($request->descuento ?? 0)
            + ($request->recargo_domicilio ?? 0)
            + $recargoCalculado;

        $diaCobro = is_numeric($cliente->dia_cobro) ? (int) $cliente->dia_cobro : 1;

        if ($ultimaVenta) {
            $periodoInicio = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        } else {
            $hoy = now()->startOfDay();
            $proximoCobro = $hoy->copy()->day($diaCobro);

            if ($hoy->day > $diaCobro) {
                $proximoCobro->addMonthNoOverflow();
            }

            $periodoInicio = $proximoCobro;
        }

        $periodoFin = $periodoInicio->copy()
            ->addMonthsNoOverflow($mesesTotales);

        $pagoPeriodoDuplicado = Venta::where('cliente_id', $cliente->id)
            ->whereDate('periodo_inicio', $periodoInicio)
            ->whereDate('periodo_fin', $periodoFin)
            ->exists();

        if ($pagoPeriodoDuplicado) {
            return redirect()->back()->with(
                'error',
                'Ya existe un pago registrado para este mismo periodo.'
            );
        }

        $venta = Venta::create([
            'usuario_id' => Auth::id(),
            'cliente_id' => $cliente->id,
            'estado' => 'pagado',
            'meses' => $meses,
            'descuento' => $request->descuento ?? 0,
            'recargo_domicilio' => $request->recargo_domicilio ?? 0,
            'recargo_atraso' => $recargoCalculado,
            'fecha_venta' => now(),
            'subtotal' => $subtotal,
            'total' => $total,
            'periodo_inicio' => $periodoInicio,
            'periodo_fin' => $periodoFin,
            'tipo_pago' => $request->tipo_pago,
        ]);

        return redirect()
            ->route('ventas.index')
            ->with('venta_id_para_imprimir', $venta->id);
    }

    public function historial()
    {
        $ventas = Venta::with(['cliente', 'usuario'])
            ->orderBy('fecha_venta', 'desc')
            ->get();

        return view('ventas_historial.index', compact('ventas'));
    }
    public function corte(Request $request)
    {
        $hoy = now()->startOfDay();

        $usuarios = \App\Models\User::all();
        $tiposClientes = Cliente::select('tipo')->distinct()->pluck('tipo');


        $clientesPendientesHoy = Cliente::where('activo', 1)
            ->where('dia_cobro', $hoy->day)
            ->whereDoesntHave('ventas', function ($q) use ($hoy) {
                $q->where('periodo_fin', '>', $hoy);
            })
            ->with([
                'paquete',
                'ventas' => function ($q) {
                    $q->orderByDesc('periodo_fin')->limit(1);
                }
            ])
            ->get();

        $clientesAtrasados = Cliente::where('activo', 1)
            ->whereHas('ventas')
            ->whereRaw("
        (
            SELECT MAX(periodo_fin)
            FROM ventas
            WHERE ventas.cliente_id = clientes.id
        ) < ?
    ", [$hoy])
            ->with([
                'paquete',
                'ventas' => function ($q) {
                    $q->orderByDesc('periodo_fin')->limit(1);
                }
            ])
            ->orderBy(
                Venta::select('periodo_fin')
                    ->whereColumn('ventas.cliente_id', 'clientes.id')
                    ->orderByDesc('periodo_fin')
                    ->limit(1),
                'asc'
            )
            ->paginate(10);


        if (
            ($clientesPendientesHoy->count() > 0 || $clientesAtrasados->count() > 0)
            && !$request->boolean('forzar_corte')
        ) {
            return view('ventas_corte.index', [
                'clientesPendientesHoy' => $clientesPendientesHoy,
                'clientesPendientesAyer' => $clientesAtrasados,
                'bloquearCorte' => true,
                'usuarios' => $usuarios,
                'tiposClientes' => $tiposClientes,
            ]);
        }

        $fecha = $request->input('fecha', $hoy->toDateString());
        $usuario_id = $request->input('usuario_id');
        $tipo_cliente = $request->input('tipo_cliente');

        $query = Venta::with(['cliente', 'usuario'])
            ->whereDate('created_at', $fecha);

        if ($usuario_id) {
            $query->where('usuario_id', $usuario_id);
        }

        if ($tipo_cliente) {
            $query->whereHas('cliente', function ($q) use ($tipo_cliente) {
                $q->where('tipo', $tipo_cliente);
            });
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();

        $totalEfectivo = $ventas->where('tipo_pago', 'Efectivo')->sum('total');
        $totalTransferencia = $ventas->where('tipo_pago', 'Transferencia')->sum('total');
        $conteoEfectivo = $ventas->where('tipo_pago', 'Efectivo')->count();
        $conteoTransferencia = $ventas->where('tipo_pago', 'Transferencia')->count();

        return view('ventas_corte.index', compact(
            'ventas',
            'usuarios',
            'tiposClientes',
            'totalEfectivo',
            'totalTransferencia',
            'conteoEfectivo',
            'conteoTransferencia'
        ));
    }

    private function obtenerAtrasoYRecargo(Cliente $cliente): array
    {
        $hoy = now()->startOfDay();

        $ventaVigente = Venta::where('cliente_id', $cliente->id)
            ->whereDate('periodo_fin', '>=', $hoy)
            ->orderByDesc('periodo_fin')
            ->first();

        if ($ventaVigente) {
            return [0, 0];
        }



        $ultimaVenta = Venta::where('cliente_id', $cliente->id)
            ->orderByDesc('fecha_venta')
            ->first();

        if (is_null($ultimaVenta)) {
            
            return [0, 0];
        }

        $fechaBase = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        $primerDiaAtraso = $fechaBase->copy()->addDay();

        $diasAtraso = 0;
        $recargo = 0;

        if ($hoy->gt($fechaBase)) {
            $diasAtraso = $fechaBase->diffInDays($hoy);
            $recargo = $diasAtraso <= 3 ? 40 : 140;
        }


        return [$diasAtraso, $recargo];
    }


    public function estadoCliente($clienteId)
    {
        $cliente = Cliente::with('ventas')->findOrFail($clienteId);
        $hoy = now()->startOfDay();
        $diaCobro = $cliente->dia_cobro ?? 1;

        $ultimaVenta = $cliente->ventas->sortByDesc('fecha_venta')->first();

        if (is_null($ultimaVenta)) {
            return response()->json([
                'estado' => 'nuevo',
                'mensaje' => 'Cliente nuevo. no ha realizado pagos.'
            ]);
        }

        $periodoFin = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        $mesAnio = $periodoFin->locale('es')->isoFormat('MMMM [de] YYYY');
        $mesAnio = ucfirst($mesAnio);

        if ($hoy->lt($periodoFin)) {
            $diasRestantes = $hoy->diffInDays($periodoFin);
            if ($diasRestantes <= 5) {
                return response()->json([
                    'estado' => 'proximo',
                    'mensaje' => "Cliente proximo a pagar. Esta cubierto hasta {$mesAnio}"
                ]);
            } else {
                return response()->json([
                    'estado' => 'corriente',
                    'mensaje' => "Cliente al corriente. Pagado hasta el mes de {$mesAnio}"
                ]);
            }
        } else {
            return response()->json([
                'estado' => 'atrasado',
                'mensaje' => "Cliente con atraso. Su ultimo mes cubierto fue {$mesAnio}"
            ]);
        }
    }

    public function pagarPorTransferencia(Request $request)
    {
        $clientesIds = $request->clientes ?? [];
        $hoy = now()->startOfDay();

        foreach ($clientesIds as $clienteId) {

            $cliente = Cliente::with(['paquete', 'ventas'])->find($clienteId);

            if (!$cliente || !$cliente->paquete) {
                continue;
            }

            $precio = $cliente->paquete->precio;
            $ultimaVenta = $cliente->ventas
                ->sortByDesc('periodo_fin')
                ->first();
            if ($ultimaVenta) {
                $periodoInicio = $ultimaVenta->periodo_fin->copy();
            } else {
                $periodoInicio = $hoy;
            }

            $periodoFin = $periodoInicio->copy()->addMonthNoOverflow();

            Venta::create([
                'usuario_id' => auth()->id(),
                'cliente_id' => $cliente->id,
                'estado' => 'pagado',
                'meses' => 1,
                'descuento' => 0,
                'recargo_domicilio' => 0,
                'recargo_atraso' => 0,
                'fecha_venta' => now(),
                'subtotal' => $precio,
                'total' => $precio,
                'periodo_inicio' => $periodoInicio,
                'periodo_fin' => $periodoFin,
                'tipo_pago' => 'Transferencia',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Pagos por transferencia registrados correctamente.');
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'meses' => 'required|integer|min:1|max:12',
            'tipo_pago' => 'required|in:Efectivo,Transferencia',
            'descuento' => 'nullable|numeric|min:0',
            'recargo_domicilio' => 'nullable|numeric|min:0',
            'recargo_falta_pago' => 'nullable|numeric|min:0',
        ]);

        $cliente = $venta->cliente()->with('paquete')->first();

        if (!$cliente || !$cliente->paquete) {
            return redirect()->back()->with('error', 'El cliente no tiene paquete asignado.');
        }

        $precioBase = $cliente->paquete->precio;
        $meses = (int) $request->meses;

        $mesesExtra = 0;
        if ($meses === 6) {
            $mesesExtra = 1;
        } elseif ($meses === 12) {
            $mesesExtra = 2;
        }

        $mesesTotales = $meses + $mesesExtra;

        $subtotal = $precioBase * $meses;
        $total = $subtotal
            - ($request->descuento ?? 0)
            + ($request->recargo_domicilio ?? 0)
            + ($request->recargo_falta_pago ?? 0);

        $ultimaVenta = Venta::where('cliente_id', $cliente->id)
            ->where('id', '!=', $venta->id)
            ->orderBy('fecha_venta', 'desc')
            ->first();

        $diaCobro = is_numeric($cliente->dia_cobro) ? (int) $cliente->dia_cobro : 1;

        if ($ultimaVenta) {
            $periodoInicio = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        } else {
            $hoy = now()->startOfDay();
            $proximoCobro = $hoy->copy()->day($diaCobro);
            if ($hoy->day > $diaCobro) {
                $proximoCobro->addMonthNoOverflow();
            }
            $periodoInicio = $proximoCobro;
        }

        $periodoFin = $periodoInicio->copy()->addMonthsNoOverflow($mesesTotales);

        $venta->update([
            'meses' => $meses,
            'tipo_pago' => $request->tipo_pago,
            'descuento' => $request->descuento ?? 0,
            'recargo_domicilio' => $request->recargo_domicilio ?? 0,
            'recargo_falta_pago' => $request->recargo_falta_pago ?? 0,
            'subtotal' => $subtotal,
            'total' => $total,
            'periodo_inicio' => $periodoInicio,
            'periodo_fin' => $periodoFin,
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada correctamente ✨');
    }


    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('ventas.historial')->with('success', 'Venta eliminada correctamente.');
    }

    public function cerrarCorteHoy(Request $request)
    {
        return redirect()->route('ventas.corte', array_merge(
            $request->only(['fecha', 'usuario_id', 'tipo_cliente']),
            ['forzar_corte' => 1]
        ))->with('info', 'Corte revisado sin registrar transferencias.');
    }

    public function filtrarCorte(Request $request)
    {
        $fecha = $request->fecha ?? now()->toDateString();
        $usuario_id = $request->usuario_id;
        $tipo_cliente = $request->tipo_cliente;

        $query = Venta::with(['cliente', 'usuario'])
            ->whereDate('created_at', $fecha);

        if ($usuario_id) {
            $query->where('usuario_id', $usuario_id);
        }

        if ($tipo_cliente) {
            $query->whereHas('cliente', function ($q) use ($tipo_cliente) {
                $q->where('tipo', $tipo_cliente);
            });
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();

        return response()->json([
            'ventas' => $ventas,
            'totalEfectivo' => $ventas->where('tipo_pago', 'Efectivo')->sum('total'),
            'totalTransferencia' => $ventas->where('tipo_pago', 'Transferencia')->sum('total'),
            'conteoEfectivo' => $ventas->where('tipo_pago', 'Efectivo')->count(),
            'conteoTransferencia' => $ventas->where('tipo_pago', 'Transferencia')->count(),
            'totalGeneral' => $ventas->sum('total'),
        ]);
    }
}
