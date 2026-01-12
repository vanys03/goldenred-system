<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('equipos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'marca_antena' => 'required|string',
            'modelo_antena' => 'required|string',
            'numero_serie_antena' => 'required|string|unique:equipo',
            'marca_router' => 'required|string',
            'modelo_router' => 'required|string',
            'numero_serie_router' => 'required|string|unique:equipo',
        ]);
    
        // Guardamos en una variable para que Spatie pueda hacer el tracking
        $equipo = Equipo::create($request->all());
    
        return redirect()->route('equipos.index')->with('success', 'Equipo registrado correctamente.');
    }
    
}
