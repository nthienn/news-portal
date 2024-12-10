<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolePermissionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:access management index,admin', only: ['index']),
            new Middleware('permission:access management create,admin', only: ['create', 'store']),
            new Middleware('permission:access management edit,admin', only: ['edit', 'update']),
            new Middleware('permission:access management delete,admin', only: ['destroy'])
        ];
    }

    function index()
    {
        $roles = Role::all();

        return view('admin.role.index', ['roles' => $roles]);
    }

    function create()
    {
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.role.create', ['permissions' => $permissions]);
    }

    function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        // create a new role
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);

        // assign permissions to the role
        $role->syncPermissions($request->permissions);

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.role.index');
    }

    function edit(string $id)
    {
        $permissions = Permission::all()->groupBy('group_name');
        $role = Role::findOrFail($id);
        $rolesPermissions = $role->permissions;
        $rolesPermissions = $rolesPermissions->pluck('name')->toArray();

        return view('admin.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolesPermissions' => $rolesPermissions
        ]);
    }

    function update(Request $request, string $id)
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        // create a new role
        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $request->role]);

        // assign permissions to the role
        $role->syncPermissions($request->permissions);

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->route('admin.role.index');
    }

    function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            if ($role->name === 'Admin') {
                return response(['status' => 'error', 'message' => __("admin.Can't delete the Admin!")]);
            }
            $role->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}