<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubscriberController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:subscriber index,admin', only: ['index']),
            new Middleware('permission:subscriber send mail,admin', only: ['store']),
            new Middleware('permission:subscriber delete,admin', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Subscriber::all();

        return view('admin.subscriber.index', ['subscribers' => $subscribers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        $subscribers = Subscriber::pluck('email')->toArray();

        Mail::to($subscribers)->send(new Newsletter($request->subject, $request->message));

        toast(__('admin.Mail sent successfully!'), 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        try {
            $subscriber->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}