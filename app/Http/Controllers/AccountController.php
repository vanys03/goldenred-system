<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Platform;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('platform')->get();
        $platforms = Platform::all();

        return view('accounts.index', compact('accounts', 'platforms'));
    }

    public function create()
    {
        $platforms = Platform::all();
        return view('accounts.create', compact('platforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'email' => 'required|string|email|max:150|unique:accounts,email,NULL,id,platform_id,' . $request->platform_id,
            'password' => 'required|string|min:6',
            'notes' => 'nullable|string|max:255',
        ]);

        $data['password_encrypted'] = Hash::make($data['password']);
        $data['password_plain'] = $data['password'];

        unset($data['password']);

        // Crear la cuenta
        $account = Account::create($data);

        /*
        |--------------------------------------------------------------------------
        | DEFINIR CANTIDAD DE PERFILES POR NOMBRE DE PLATAFORMA
        |--------------------------------------------------------------------------
        */
        $platformName = strtolower($account->platform->name);

        $profilesCount = match ($platformName) {
            'netflix' => 5,
            'disney', 'disney+', 'disney plus', 'disney plos' => 7,
            'prime', 'amazon prime', 'prime video', 'amazon' => 6,
            'hbo', 'hbo max' => 5,
            default => 6,
        };

        // Crear perfiles automáticamente
        for ($i = 1; $i <= $profilesCount; $i++) {
            Profile::create([
                'account_id' => $account->id,
                'name' => "Perfil $i",
                'status' => 'available',
                'current_holder' => null,
                'assigned_since' => null,
                'notes' => null,
            ]);
        }

        if ($request->platform_id) {
            return redirect()
                ->route('platforms.accounts', $request->platform_id)
                ->with('success', 'Cuenta y perfiles creados correctamente.');
        }

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Cuenta y perfiles creados correctamente.');
    }

    public function show(Account $account)
    {
        $account->load('platform', 'profiles');
        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        $platforms = Platform::all();
        return view('accounts.edit', compact('account', 'platforms'));
    }

    public function update(Request $request, Account $account)
    {
        $data = $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'email' => 'required|string|email|max:150',
            'password' => 'nullable|string|min:6',
            'notes' => 'nullable|string',
        ]);

        if (!empty($data['password'])) {
            $data['password_encrypted'] = Hash::make($data['password']);
            $data['password_plain'] = $data['password'];
        }

        unset($data['password']);

        $account->update($data);

        return redirect()
            ->route('accounts.show', $account)
            ->with('success', 'Cuenta actualizada.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return back()->with('success', 'Cuenta eliminada correctamente.');
    }

    public function byPlatform(Platform $platform)
    {
        $accounts = $platform->accounts()->with('platform')->get();
        return view('accounts.index', compact('accounts', 'platform'));
    }

    public function changePassword(Request $request, Account $account)
    {
        $request->validate([
            'newPassword' => 'required|min:6|confirmed',
        ]);

        $account->password_plain = $request->newPassword;
        $account->password_encrypted = Hash::make($request->newPassword);
        $account->save();

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
