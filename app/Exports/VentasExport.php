<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromCollection, WithHeadings
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function collection()
    {
        return Venta::with(['cliente', 'usuario'])
            ->whereBetween('created_at', [$this->fechaInicio . ' 00:00:00', $this->fechaFin . ' 23:59:59'])
            ->get()
            ->map(function ($venta) {
                return [
                    'Cliente' => $venta->cliente->nombre,
                    'Usuario' => $venta->usuario->name,
                    'Fecha' => $venta->created_at->format('Y-m-d H:i'),
                    'Método de pago' => ucfirst($venta->tipo_pago ?? 'N/A'),
                    'Total' => number_format($venta->total, 2),
                ];
            });
    }

    public function headings(): array
    {
        return ['Cliente', 'Usuario', 'Fecha', 'Método de pago', 'Total'];
    }
}
