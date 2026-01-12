<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        if ($user->can('Ver dashboard')) {
            $dashboardData = $this->getDashboardData($request);
            return view('dashboard.index', $dashboardData);
        }

        // Datos básicos para la vista limitada
        $clientesDeHoy = Cliente::where('dia_cobro', now()->day)
            ->where('activo', 1)
            ->get();

        $clientesAtrasados = Cliente::where('activo', 1)
            ->get()
            ->filter(function ($cliente) {
                return $cliente->getEstadoPagoActual()['estado'] === 'atrasado';
            });

        return view('dashboard.limitado', compact('clientesDeHoy', 'clientesAtrasados'));

    }

    protected function getDashboardData(Request $request): array
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $clientesDeHoy = Cliente::where('dia_cobro', now()->day)
            ->where('activo', 1)
            ->get();

        $clientesAtrasados = Cliente::where('activo', 1)
            ->get()
            ->filter(function ($cliente) {
                return $cliente->getEstadoPagoActual()['estado'] === 'atrasado';
            });

        return [
            'ventasMensuales' => $this->getVentasDelMesActual(),
            'ventasAnuales' => $this->getVentasAnuales(),
            'clientesTotales' => $this->getClientesTotales(),
            'clientesConDeuda' => $this->getClientesConDeuda(),
            'clientesPagados' => $this->getClientesPagados(),
            'clientesPendientesPago' => $this->getClientesPendientesDePago(),
            'mesActual' => now()->month,
            'meses' => $meses,
            'ventasPorMes' => collect($meses)->keys()->map(function ($mes) {
                return Venta::whereMonth('periodo_inicio', $mes)
                    ->whereYear('periodo_inicio', now()->year)
                    ->sum('total');
            })->values(),
            'clientesDeHoy' => $clientesDeHoy,
            'clientesAtrasados' => $clientesAtrasados,
        ];
    }



    protected function getVentasDelMesActual(): float
    {
        return Venta::whereMonth('periodo_inicio', now()->month)
            ->whereYear('periodo_inicio', now()->year)
            ->sum('total');
    }

    protected function getVentasAnuales(): float
    {
        return Venta::whereYear('periodo_inicio', now()->year)
            ->sum('total');
    }

    protected function getClientesTotales(): int
    {
        return Cliente::count();
    }


    protected function getClientesConDeuda(): int
    {
        $hoy = now()->startOfDay();

        // 1. Clientes que tienen ventas y están atrasados
        $clientesConVentasAtrasadas = DB::table('clientes as c')
            ->join(DB::raw("(SELECT cliente_id, MAX(periodo_fin) as max_fin 
                         FROM ventas 
                         GROUP BY cliente_id) as v_max"), 'c.id', '=', 'v_max.cliente_id')
            ->join('ventas as v', function ($join) {
                $join->on('v.cliente_id', '=', 'v_max.cliente_id')
                    ->on('v.periodo_fin', '=', 'v_max.max_fin');
            })
            ->where(function ($query) use ($hoy) {
                $query->where('v.estado', 'pendiente')
                    ->orWhere('v.periodo_fin', '<', $hoy);
            })
            ->pluck('c.id')
            ->toArray();

        // 2. Clientes que NO tienen ventas pero ya pasó su día de cobro
        $clientesSinVentas = Cliente::doesntHave('ventas')->get();
        $clientesSinVentasAtrasados = $clientesSinVentas->filter(function ($cliente) use ($hoy) {
            $diaCobro = $cliente->dia_cobro ?? 1;
            $referencia = $hoy->copy()->day($diaCobro);
            if ($hoy->lt($referencia)) {
                $referencia->subMonthNoOverflow();
            }
            $primerDiaAtraso = $referencia->copy()->addDay();
            return $hoy->gte($primerDiaAtraso);
        })->pluck('id')->toArray();

        return count(array_unique(array_merge($clientesConVentasAtrasadas, $clientesSinVentasAtrasados)));
    }


    protected function getClientesPagados(): int
    {
        $hoy = now()->startOfDay();

        return DB::table('clientes as c')
            ->join(DB::raw("(SELECT cliente_id, MAX(periodo_fin) as max_fin 
                         FROM ventas 
                         GROUP BY cliente_id) as v_max"), 'c.id', '=', 'v_max.cliente_id')
            ->join('ventas as v', function ($join) {
                $join->on('v.cliente_id', '=', 'v_max.cliente_id')
                    ->on('v.periodo_fin', '=', 'v_max.max_fin');
            })
            ->where('v.estado', 'pagado')
            ->where('v.periodo_fin', '>=', $hoy)
            ->count();
    }


    protected function getClientesPendientesDePago(): int
    {
        $hoy = now()->startOfDay();
        $diaHoy = $hoy->day;

        // 1. Clientes sin ventas, pero hoy es su día de cobro
        $clientesSinVentas = Cliente::doesntHave('ventas')
            ->where('dia_cobro', $diaHoy)
            ->pluck('id')
            ->toArray();

        // 2. Clientes con ventas cuya última venta NO cubre hasta hoy y su día de cobro es hoy
        $clientesConVentas = DB::table('clientes as c')
            ->join(DB::raw("(SELECT cliente_id, MAX(periodo_fin) as max_fin 
                         FROM ventas 
                         GROUP BY cliente_id) as v_max"), 'c.id', '=', 'v_max.cliente_id')
            ->join('ventas as v', function ($join) {
                $join->on('v.cliente_id', '=', 'v_max.cliente_id')
                    ->on('v.periodo_fin', '=', 'v_max.max_fin');
            })
            ->where('c.dia_cobro', $diaHoy)
            ->where(function ($q) use ($hoy) {
                $q->where('v.periodo_fin', '<', $hoy)
                    ->orWhere('v.estado', 'pendiente');
            })
            ->pluck('c.id')
            ->toArray();

        return count(array_unique(array_merge($clientesSinVentas, $clientesConVentas)));
    }


}
