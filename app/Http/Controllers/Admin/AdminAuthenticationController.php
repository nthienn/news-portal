<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordResetLinkRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Mail\AdminPasswordResetLinkMail;
use App\Models\Admin;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;

class AdminAuthenticationController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        $request->authenticate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(PasswordResetLinkRequest $request)
    {
        $token = \Str::random(64);

        $admin = Admin::where('email', $request->email)->first();
        $admin->remember_token = $token;
        $admin->save();

        Mail::to($request->email)->send(new AdminPasswordResetLinkMail($token, $request->email));

        return redirect()->back()->with('success', 'A mail has been sent to your email address, please check!');
    }

    public function resetPassword($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    public function handleResetPassword(ResetPasswordRequest $request)
    {
        $admin = Admin::where(['email' => $request->email, 'remember_token' => $request->token])->first();

        if (!$admin) {
            return back()->with('error', 'Token is invalid');
        }

        $admin->password = Hash::make($request->password);
        $admin->remember_token = null;
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Reset Password Successfully');
    }
}