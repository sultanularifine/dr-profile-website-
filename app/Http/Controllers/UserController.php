<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-list', ['only' => ['show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    private function preventUnauthorizedPrivilegedRoleAssignment(array $roleNames): void
    {
        // Only the Super Admin can grant operational/admin staff roles. Other authorized
        // user managers may register Patients, but cannot promote accounts.
        $privilegedRoles = ['Super Admin', 'Admin', 'Doctor', 'Receptionist'];
        $requestedPrivilegedRoles = array_intersect($privilegedRoles, $roleNames);
        if ($requestedPrivilegedRoles !== [] && !auth()->user()?->hasRole('Super Admin')) {
            abort(403, 'Only a Super Admin can assign administrative or staff roles.');
        }
    }

    public function index(Request $request): View
    {
        $data = User::latest()->paginate(5);

        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'same:confirm-password'],
            'confirm-password' => ['required', 'string', 'min:8'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);
        $roleNames = array_values(array_unique($request->input('roles', [])));
        $this->preventUnauthorizedPrivilegedRoleAssignment($roleNames);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->syncRoles($roleNames);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id): View
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('Super Admin') && !auth()->user()?->hasRole('Super Admin')) {
            abort(403, 'Only a Super Admin can edit a Super Admin account.');
        }
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'same:confirm-password'],
            'confirm-password' => ['nullable', 'string', 'min:8'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);
        $roleNames = array_values(array_unique($request->input('roles', [])));
        $this->preventUnauthorizedPrivilegedRoleAssignment($roleNames);
        if ($user->hasRole('Super Admin') && !auth()->user()?->hasRole('Super Admin')) {
            abort(403, 'Only a Super Admin can update a Super Admin account.');
        }
        if ($user->hasRole('Super Admin') && !in_array('Super Admin', $roleNames, true)
            && !User::role('Super Admin')->where('id', '!=', $user->id)->exists()) {
            abort(422, 'At least one Super Admin account must remain active.');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        $user->syncRoles($roleNames);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        abort_if($user->id === auth()->id(), 422, 'You cannot delete your own signed-in account.');
        if ($user->hasRole('Super Admin')) {
            abort(422, 'Super Admin accounts are protected from deletion.');
        }

        // Preserve clinical records. Do not delete an account with linked appointments or prescriptions.
        if (Schema::hasTable('appointments') && $user->appointmentsAsPatient()->exists()) {
            return redirect()->route('users.index')->with('error', 'This account has appointment records. Deletion is blocked to preserve the medical history.');
        }
        if (Schema::hasTable('prescriptions') && ($user->prescriptionsAsPatient()->exists() || $user->prescriptionsAsAuthor()->exists())) {
            return redirect()->route('users.index')->with('error', 'This account has prescription records. Deletion is blocked to preserve the medical history.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
