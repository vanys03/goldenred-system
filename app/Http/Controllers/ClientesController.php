<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Cliente;
use App\Models\Paquete;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Ver clientes')->only(['index', 'show']);
        $this->middleware('permission:Crear clientes')->only(['create', 'store']);
        $this->middleware('permission:Editar clientes')->only(['edit', 'update']);
        $this->middleware('permission:Eliminar clientes')->only('destroy');
    }

    public function index()
    {
        $clientes = Cliente::all();
        $paquetes = Paquete::all();
        return view('clientes.index', compact('clientes', 'paquetes'));
    }

    public function create()
    {
        $paquetes = Paquete::all();
        return view('clientes.create', compact('paquetes'));
    }

    public function editModal($id)
    {
        $cliente = Cliente::findOrFail($id);
        $paquetes = Paquete::select('id', 'nombre', 'precio')->get();
        return view('clientes.partials.modal-edit', compact('cliente', 'paquetes'));
    }

    public function deleteModal($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.partials.modal-delete', compact('cliente'));
    }

    public function store(Request $request)
{
    // Asignar tipo B por defecto
    $request->merge(['tipo' => 'B']);

    $request->validate([
        'nombre' => 'required|string|max:120',
        'telefono1' => 'nullable|string|max:20',
        'telefono2' => 'nullable|string|max:20',
        'fecha_contrato' => 'required|date',
        'dia_cobro' => 'required|integer|min:1|max:31',
        'paquete_id' => 'nullable|exists:paquetes,id',
        'Mac' => 'nullable|string|max:255',
        'IP' => 'nullable|string|max:255',
        'direccion' => 'nullable|string|max:255',
        'coordenadas' => 'nullable|string|max:60',
        'referencias' => 'nullable|string',
        'torre' => 'nullable|string|max:255',
        'panel' => 'nullable|string|max:255',
        'activo' => 'nullable|boolean',
        'zona' => 'nullable|string|max:255',
        'tipo' => 'required|in:A,B,C', // sigue siendo requerido, pero ya lo forzamos a B
    ]);

    $data = $request->all();
    $data['activo'] = true;

    Cliente::create($data);

    return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
}


    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $paquetes = Paquete::all();
        return view('clientes.edit', compact('cliente', 'paquetes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:120',
            'telefono1' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'fecha_contrato' => 'required|date',
            'dia_cobro' => 'required|integer|min:1|max:31',
            'paquete_id' => 'nullable|exists:paquetes,id',
            'Mac' => 'nullable|string|max:255',
            'IP' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'coordenadas' => 'nullable|string|max:60',
            'referencias' => 'nullable|string',
            'torre' => 'nullable|string|max:255',
            'panel' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
            'zona' => 'nullable|string|max:255',
            'tipo' => 'required|in:A,B,C', // ✅ nuevo campo
        ]);

        $cliente = Cliente::findOrFail($id);

        $cliente->update($request->only([
            'nombre',
            'telefono1',
            'telefono2',
            'fecha_contrato',
            'dia_cobro',
            'paquete_id',
            'Mac',
            'IP',
            'direccion',
            'coordenadas',
            'referencias',
            'torre',
            'panel',
            'activo',
            'zona',
            'tipo', // ✅ nuevo campo
        ]));

        if ($request->has('equipo')) {
            $equipoData = $request->input('equipo');

            $filteredEquipo = array_map(function ($value) {
                return $value === '' ? null : $value;
            }, $equipoData);

            $hasData = collect($filteredEquipo)->filter(function ($value) {
                return !is_null($value);
            })->isNotEmpty();

            if ($hasData) {
                $cliente->equipos()->updateOrCreate(
                    ['cliente_id' => $cliente->id],
                    array_merge($filteredEquipo, ['cliente_id' => $cliente->id])
                );
            } else {
                $equipoExistente = $cliente->equipos()->where('cliente_id', $cliente->id)->first();
                if ($equipoExistente) {
                    $equipoExistente->delete();
                }
            }
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente y equipo actualizados correctamente.');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
