<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Auth;
use Hash;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, string $id)
    {
        $imagePath = $this->handleFileUpload($request, 'image', $request->old_image);

        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        Alert::success('Success', 'Profile updated successfully');
        return redirect()->back();
    }

    /**
     * Update the specified resource for password.
     */
    public function updatePassword(UpdatePasswordRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->password = Hash::make($request->password);
        $admin->save();

        Alert::success('Success', 'Password updated successfully');
        return redirect()->back();
    }
}