<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private const PRIVILEGED_ROLE_NAMES = ['Super Admin', 'Admin', 'Doctor', 'Receptionist'];

    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index']]);
        $this->middleware('permission:role-list', ['only' => ['show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    private function isPrivilegedRoleName(string $name): bool
    {
        return in_array($name, self::PRIVILEGED_ROLE_NAMES, true);
    }

    private function guardPrivilegedRoleName(string $name): void
    {
        abort_if(
            $this->isPrivilegedRoleName($name) && !auth()->user()?->hasRole('Super Admin'),
            403,
            'Only a Super Admin can create or modify privileged system roles.'
        );
    }

    private function guardSuperAdminRoleIsLocked(Role $role): void
    {
        abort_if(
            $role->name === 'Super Admin',
            403,
            'The Super Admin role is locked to prevent accidental administrator lockout.'
        );
    }

    private function guardSensitivePermissions(array $permissionIds): void
    {
        $hasSensitivePermission = Permission::query()
            ->whereIn('id', $permissionIds)
            ->where(function ($query) {
                $query->where('name', 'manage-permissions')
                    ->orWhere('name', 'like', 'user-%')
                    ->orWhere('name', 'like', 'role-%');
            })
            ->exists();

        abort_if(
            $hasSensitivePermission && !auth()->user()?->hasRole('Super Admin'),
            403,
            'Only a Super Admin can grant user/role administration permissions.'
        );
    }

    public function index(Request $request): View
    {
        $roles = Role::query()->orderByDesc('id')->paginate(10)->withQueryString();

        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $permission = Permission::query()->orderBy('name')->get();

        return view('roles.create', compact('permission'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permission' => ['nullable', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        $this->guardPrivilegedRoleName($data['name']);
        $permissionIds = $data['permission'] ?? [];
        $this->guardSensitivePermissions($permissionIds);

        $role = DB::transaction(function () use ($data, $permissionIds) {
            $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
            $permissionNames = Permission::query()
                ->where('guard_name', 'web')
                ->whereIn('id', $permissionIds)
                ->pluck('name')
                ->all();
            $role->syncPermissions($permissionNames);

            return $role;
        });

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' created successfully.");
    }

    public function show($id): View
    {
        $role = Role::query()->findOrFail($id);
        $rolePermissions = $role->permissions()->orderBy('name')->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id): View
    {
        $role = Role::query()->findOrFail($id);
        $this->guardSuperAdminRoleIsLocked($role);
        $this->guardPrivilegedRoleName($role->name);

        $permission = Permission::query()->orderBy('name')->get();
        $rolePermissions = $role->permissions()->pluck('permissions.id', 'permissions.id')->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $role = Role::query()->findOrFail($id);
        $this->guardSuperAdminRoleIsLocked($role);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permission' => ['nullable', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        $this->guardPrivilegedRoleName($role->name);
        $this->guardPrivilegedRoleName($data['name']);
        $permissionIds = $data['permission'] ?? [];
        $this->guardSensitivePermissions($permissionIds);

        DB::transaction(function () use ($role, $data, $permissionIds) {
            $role->name = $data['name'];
            $role->save();

            $permissionNames = Permission::query()
                ->where('guard_name', 'web')
                ->whereIn('id', $permissionIds)
                ->pluck('name')
                ->all();
            $role->syncPermissions($permissionNames);
        });

        return redirect()->route('roles.index')->with('success', "Role '{$data['name']}' updated successfully.");
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::query()->findOrFail($id);

        if ($this->isPrivilegedRoleName($role->name)) {
            return redirect()->route('roles.index')->with('error', 'Privileged system roles are protected from deletion.');
        }

        if (User::role($role->name)->exists()) {
            return redirect()->route('roles.index')->with('error', 'This role is assigned to one or more accounts. Reassign those accounts before deleting it.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' deleted successfully.");
    }
}
