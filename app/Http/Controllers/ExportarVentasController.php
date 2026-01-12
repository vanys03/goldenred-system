<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportarVentasController extends Controller
{
    public function exportar(Request $request)
    {
        // Validamos que las fechas sean correctas
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Descargamos el archivo Excel con nombre personalizado
        return Excel::download(
            new VentasExport($request->fecha_inicio, $request->fecha_fin),
            'ventas_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
