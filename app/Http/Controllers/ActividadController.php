<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Actividad;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ActividadController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Ver actividades')->only('index', 'show');
    }

    public function index(Request $request)
    {
        $usuarios = User::onlyBasicFields()->get();
        return view('actividades.index', compact('usuarios'));
    }

    public function data(Request $request)
{
    $query = Actividad::select(
        'actividades.id',
        'actividades.ip',
        'actividades.dispositivo',
        'actividades.fecha',
        'actividades.hora_entrada',
        'actividades.hora_salida',
        'users.name as usuario'
    )->join('users', 'users.id', '=', 'actividades.usuario_id');

    if ($request->filled('usuario_id')) {
        $query->where('actividades.usuario_id', $request->usuario_id);
    }

    if ($request->filled('fecha')) {
        $query->where('actividades.fecha', $request->fecha);
    }

    return DataTables::eloquent($query)
        ->editColumn('usuario', function ($row) {
            return '
                <div class="d-flex px-2 py-1">
                    <div class="my-auto">
                        <h6 class="mb-0 text-xs">' . e($row->usuario) . '</h6>
                    </div>
                </div>';
        })
        ->editColumn('ip', function ($row) {
            return '<p class="text-xs font-weight-normal mb-0">' . e($row->ip) . '</p>';
        })
        ->editColumn('dispositivo', function ($row) {
            return '<p class="text-xs font-weight-normal mb-0">' . e($row->dispositivo) . '</p>';
        })
        ->editColumn('fecha', function ($row) {
            return '<p class="text-xs font-weight-normal mb-0">' . e($row->fecha) . '</p>';
        })
        ->editColumn('hora_entrada', function ($row) {
            return '<p class="text-xs font-weight-normal mb-0 text-success">' . e($row->hora_entrada) . '</p>';
        })
        ->editColumn('hora_salida', function ($row) {
            return '<p class="text-xs font-weight-normal mb-0 text-danger">' . e($row->hora_salida ?? '—') . '</p>';
        })
        ->rawColumns(['usuario', 'ip', 'dispositivo', 'fecha', 'hora_entrada', 'hora_salida'])
        ->filterColumn('usuario', function ($query, $keyword) {
            $query->whereRaw("LOWER(users.name) LIKE ?", ["%" . strtolower($keyword) . "%"]);
        })
        ->make(true);
}

}