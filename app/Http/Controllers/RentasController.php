<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class RentasController extends Controller
{
    public function index()
    {
        // Si quieres pasar datos iniciales (ejemplo: lista de clientes)
        $rentas = Renta::with(['cliente', 'usuario'])->get();

        return view('rentas.index', compact('rentas'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_renta_id' => 'required|exists:clientes_rentas,id',
            'meses' => 'required|integer|min:1|max:12',
            'descuento' => 'nullable|numeric|min:0',
            'recargo_domicilio' => 'nullable|numeric|min:0',
            'tipo_pago' => 'required|in:Efectivo,Transferencia',
        ]);

        // Obtener precio desde el cliente
        $cliente = \App\Models\ClienteRenta::findOrFail($validated['cliente_renta_id']);
        $precio = $cliente->precio ?? 300;

        // Calcular subtotal y total
        $subtotal = $precio * $validated['meses'];
        $total = $subtotal - ($validated['descuento'] ?? 0) + ($validated['recargo_domicilio'] ?? 0);

        // Crear la renta
        $renta = Renta::create([
            'cliente_renta_id' => $validated['cliente_renta_id'],
            'user_id' => auth()->id(),
            'meses' => $validated['meses'],
            'descuento' => $validated['descuento'] ?? 0,
            'recargo_domicilio' => $validated['recargo_domicilio'] ?? 0,
            'fecha_venta' => now()->toDateString(),
            'subtotal' => $subtotal,
            'total' => $total,
            'estado' => 'activa',
            'tipo_pago' => $validated['tipo_pago'],
        ]);

        // ✅ Redirigir con mensaje flash y el ID para imprimir ticket
        return redirect()->route('rentas.index')
            ->with('success', '✅ La renta se guardó correctamente')
            ->with('renta_id_para_imprimir', $renta->id);
    }



    public function show($id)
    {
        return Renta::with(['cliente', 'usuario'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $renta = Renta::findOrFail($id);
        $renta->update($request->all());

        return response()->json($renta);
    }

    public function destroy($id)
    {
        Renta::destroy($id);

        return redirect()
            ->route('rentas_historial.index')
            ->with('success', '✅ La renta se eliminó correctamente');
    }
    public function detalle($id)
    {
        $renta = Renta::with(['cliente', 'usuario'])->findOrFail($id);

        return view('rentas_historial.partials.detalle', compact('renta'));
    }


    public function historial()
    {
        $historial = Renta::with(['cliente', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Si tu archivo está en resources/views/rentas_historial/index.blade.php:
        return view('rentas_historial.index', compact('historial'));
    }
    public function data()
    {
        $query = Renta::select(
            'rentas.id',
            'rentas.meses',
            'rentas.recargo_domicilio',
            'rentas.total',
            'rentas.fecha_venta',
            'clientes_rentas.nombre as cliente',
            'users.name as usuario'
        )
            ->join('clientes_rentas', 'clientes_rentas.id', '=', 'rentas.cliente_renta_id')
            ->join('users', 'users.id', '=', 'rentas.user_id');

        return DataTables::eloquent($query)

            ->editColumn(
                'cliente',
                fn($r) =>
                '<h6 class="mb-0 text-xs">' . e($r->cliente) . '</h6>'
            )

            ->editColumn(
                'usuario',
                fn($r) =>
                '<p class="text-xs mb-0">' . e($r->usuario) . '</p>'
            )

            ->editColumn(
                'meses',
                fn($r) =>
                '<p class="text-xs mb-0 text-center">' . $r->meses . '</p>'
            )

            ->addColumn(
                'recargo',
                fn($r) =>
                '<p class="text-xs mb-0 text-center">$' . number_format($r->recargo_domicilio, 2) . '</p>'
            )

            ->editColumn(
                'total',
                fn($r) =>
                '<p class="text-xs mb-0 fw-bold text-center">$' . number_format($r->total, 2) . '</p>'
            )

            ->editColumn(
                'fecha_venta',
                fn($r) =>
                '<p class="text-xs text-secondary mb-0 text-center">' .
                Carbon::parse($r->fecha_venta)->format('d/m/Y') .
                '</p>'
            )

            ->addColumn('acciones', fn($r) => '
            <button class="btn btn-link text-info p-0 mx-1 ver-renta"
                data-id="' . $r->id . '">
                <span class="material-icons">visibility</span>
            </button>

            <button class="btn btn-link text-danger p-0 mx-1 eliminar-renta"
                data-id="' . $r->id . '">
                <span class="material-icons">delete_forever</span>
            </button>
        ')

            ->rawColumns([
                'cliente',
                'usuario',
                'meses',
                'recargo',
                'total',
                'fecha_venta',
                'acciones'
            ])

            ->make(true);
    }


}
