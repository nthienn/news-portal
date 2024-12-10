<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Language;
use App\Models\ReceivedMail;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:contact index,admin', only: ['index']),
            new Middleware('permission:contact edit,admin', only: ['update'])
        ];
    }

    public function index()
    {
        $languages = Language::all();

        return view('admin.contact.index', ['languages' => $languages]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => ['required', 'max:500'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email']
        ]);

        Contact::updateOrCreate(
            ['language' => $request->language],
            [
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email
            ]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }
}