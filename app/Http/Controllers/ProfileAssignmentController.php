<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ProfileAssignment;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileAssignmentController extends Controller
{
    public function index()
    {
        $assignments = ProfileAssignment::with('profile.account.platform', 'user')
            ->whereNotNull('ended_at')
            ->latest()
            ->get();

        return view('platforms_historial.index', compact('assignments'));
    }

    public function create()
    {
        $profiles = Profile::where('status', 'available')->get();
        return view('profile_assignments.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'customer_name' => 'required|string|max:150',
            'telefono' => 'nullable|string|max:20',
            'type' => 'required|in:sale,rental,reservation,release',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'price' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        ProfileAssignment::create($data);

        $profile = Profile::find($data['profile_id']);
        if ($data['type'] !== 'release') {
            $profile->update([
                'status' => 'assigned',
                'current_holder' => $data['customer_name'],
                'telefono' => $data['telefono'],
                'assigned_since' => $data['started_at'],
            ]);
        } else {
            $profile->update([
                'status' => 'available',
                'current_holder' => null,
                'telefono' => null,
                'assigned_since' => null,
            ]);
        }

        return redirect()->route('profile-assignments.index')->with('success', 'Asignación registrada.');
    }

    public function show(ProfileAssignment $profile_assignment)
    {
        $profile_assignment->load('profile.account.platform', 'user');
        return view('profile_assignments.show', compact('profile_assignment'));
    }

    public function edit(ProfileAssignment $profile_assignment)
    {
        $profiles = Profile::all();
        return view('profile_assignments.edit', compact('profile_assignment', 'profiles'));
    }

    public function update(Request $request, ProfileAssignment $profile_assignment)
    {
        $data = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'customer_name' => 'required|string|max:150',
            'telefono' => 'nullable|string|max:20',
            'type' => 'required|in:sale,rental,reservation,release',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'price' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $data['sold_by_user_id'] = auth()->id();

        $profile_assignment->update($data);

        return redirect()->route('profile-assignments.show', $profile_assignment)
            ->with('success', 'Asignación actualizada.');
    }

    public function destroy(ProfileAssignment $profile_assignment)
    {
        $profile_assignment->delete();
        return back()->with('success', 'Asignación eliminada correctamente.');
    }

    public function assign(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'current_holder' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'assigned_since' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $profile->update([
            'status' => 'assigned',
            'current_holder' => $data['current_holder'],
            'telefono' => $data['telefono'],
            'assigned_since' => $data['assigned_since'],
            'notes' => $data['notes'],
        ]);

        ProfileAssignment::create([
            'profile_id' => $profile->id,
            'customer_name' => $data['current_holder'],
            'telefono' => $data['telefono'],
            'sold_by_user_id' => auth()->id(),
            'type' => 'sale',
            'started_at' => $data['assigned_since'],
            'notes' => $data['notes'],
        ]);

        return redirect()->back()->with('success', 'Perfil asignado correctamente y registrado en historial.');
    }


    public function data(Request $request)
{
    $query = ProfileAssignment::select(
        'profile_assignments.id',
        'profile_assignments.customer_name',
        'profile_assignments.telefono',
        'profile_assignments.started_at',
        'profile_assignments.ended_at',
        'profile_assignments.sold_by_user_id',
        'profiles.name as profile_name',
        'accounts.email as account_email',
        'platforms.name as platform_name',
        'users.name as vendedor'
    )
    ->join('profiles', 'profiles.id', '=', 'profile_assignments.profile_id')
    ->join('accounts', 'accounts.id', '=', 'profiles.account_id')
    ->join('platforms', 'platforms.id', '=', 'accounts.platform_id')
    ->leftJoin('users', 'users.id', '=', 'profile_assignments.sold_by_user_id');

    return DataTables::eloquent($query)
        ->editColumn('platform_name', fn($row) => "<p class='text-xs text-center mb-0'>{$row->platform_name}</p>")
        ->editColumn('account_email', fn($row) => "<p class='text-xs text-center mb-0'>{$row->account_email}</p>")
        ->editColumn('profile_name', fn($row) => "<p class='text-xs text-center mb-0'>{$row->profile_name}</p>")
        ->editColumn('customer_name', fn($row) => "<p class='text-xs text-center mb-0'>{$row->customer_name}</p>")
        ->editColumn('telefono', fn($row) => "<p class='text-xs text-center mb-0'>" . ($row->telefono ?? '-') . "</p>")
        ->editColumn('started_at', fn($row) => "<p class='text-xs text-center mb-0'>{$row->started_at}</p>")
        ->editColumn('ended_at', fn($row) => "<p class='text-xs text-center mb-0'>" . ($row->ended_at ?? '-') . "</p>")
        ->editColumn('vendedor', fn($row) => "<p class='text-xs text-center mb-0'>" . ($row->vendedor ?? 'N/A') . "</p>")
        ->rawColumns([
            'platform_name', 'account_email', 'profile_name',
            'customer_name', 'telefono', 'started_at', 'ended_at', 'vendedor'
        ])
        ->make(true);
}

}
