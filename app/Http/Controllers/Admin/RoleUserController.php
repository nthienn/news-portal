<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUserStoreRequest;
use App\Http\Requests\Admin\RoleUserUpdateRequest;
use App\Mail\RoleUserCreateMail;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleUserController extends Controller implements HasMiddleware
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();

        return view('admin.role-user.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.role-user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleUserStoreRequest $request)
    {
        $user = new Admin();
        $user->image = '';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = 1;
        $user->save();

        // assign the role to user
        $user->assignRole($request->role);

        // send mail to the user
        Mail::to($request->email)->send(new RoleUserCreateMail($request->email, $request->password));

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.role-user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Admin::findOrFail($id);
        $roles = Role::all();

        return view('admin.role-user.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUserUpdateRequest $request, string $id)
    {
        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => ['confirmed', 'min:8']
            ]);
        }

        $user = Admin::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        /** assign the role to user */
        $user->syncRoles($request->role);

        toast(__('admin.Update Successfully!'), 'success');

        return redirect()->route('admin.role-user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Admin::findOrFail($id);
            if ($user->getRoleNames()->first() === 'Admin') {
                return response(['status' => 'error', 'message' => __("admin.Can't delete the Admin!")]);
            }
            $user->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}