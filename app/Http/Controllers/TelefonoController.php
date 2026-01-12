<?php

namespace App\Http\Controllers;

use App\Models\Telefono;

class TelefonoController extends Controller
{
    public function index()
    {
        $telefonos = Telefono::all();
        return view('telefonos.index', compact('telefonos'));
    }
}
