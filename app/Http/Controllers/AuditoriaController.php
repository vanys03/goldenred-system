<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Routing\Controller;

class AuditoriaController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('permission:Ver auditoria')->only(['index', 'show']);
    }
    public function index()
    {
        $logs = Activity::with('causer')
    ->latest()
    ->get();


        return view('auditoria.index', compact('logs'));
    }
}
