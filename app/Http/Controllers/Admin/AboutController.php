<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AboutController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:about index,admin', only: ['index']),
            new Middleware('permission:about edit,admin', only: ['update'])
        ];
    }

    public function index()
    {
        $languages = Language::all();

        return view('admin.about.index', ['languages' => $languages]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required']
        ]);

        About::updateOrCreate(
            ['language' => $request->language],
            [
                'content' => $request->content
            ]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }
}