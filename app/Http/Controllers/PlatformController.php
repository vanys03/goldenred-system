<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::withCount('accounts')->get();

        $profiles = \App\Models\Profile::with('account.platform')
            ->where('status', 'assigned')
            ->get();

        return view('platforms.index', compact('platforms', 'profiles'));
    }


    public function create()
    {
        return view('platforms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|unique:platforms,slug',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
        ]);

        // Generar slug si no se proporciona
        if (empty($data['slug'])) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;

            // Mientras exista un slug igual, agrega un número
            while (Platform::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $data['slug'] = $slug;
        }

        Platform::create($data);

        return redirect()->route('platforms.index')->with('success', 'Plataforma creada correctamente.');
    }

    public function show(Platform $platform)
    {
        $platform->load('accounts.profiles');
        return view('platforms.show', compact('platform'));
    }

    public function edit(Platform $platform)
    {
        return view('platforms.edit', compact('platform'));
    }

    public function update(Request $request, Platform $platform)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|unique:platforms,slug,' . $platform->id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $platform->update($data);

        return redirect()->route('platforms.index')->with('success', 'Plataforma actualizada.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return back()->with('success', 'Plataforma eliminada correctamente.');
    }
}
