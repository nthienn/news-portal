<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\ReceivedMail;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactMessageController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:message index,admin', only: ['index']),
            new Middleware('permission:message reply,admin', only: ['reply']),
            new Middleware('permission:message delete,admin', only: ['delete']),
        ];
    }

    public function index()
    {
        ReceivedMail::query()->update(['seen' => 1]);
        $messages = ReceivedMail::orderBy('created_at', 'DESC')->get();

        return view('admin.message.index', ['messages' => $messages]);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500']
        ]);

        try {
            $contact = Contact::where('language', 'en')->first();
            Mail::to($request->email)->send(new ContactMail($request->subject, $request->message, $contact->email));

            $replied = ReceivedMail::find($request->message_id);
            $replied->replied = 1;
            $replied->save();

            toast(__('admin.Message sent successfully!'), 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toast(__($th->getMessage()));
        }
    }

    public function delete(string $id)
    {
        try {
            $receivedMail = ReceivedMail::findOrFail($id);
            $receivedMail->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}