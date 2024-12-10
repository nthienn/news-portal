<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeSectionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:home section index,admin', only: ['index']),
            new Middleware('permission:home section edit,admin', only: ['update'])
        ];
    }

    public function index()
    {
        $languages = Language::all();

        return view('admin.home-section.index', ['languages' => $languages]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_section_one' => ['required', 'string'],
            'category_section_two' => ['required', 'string'],
            'category_section_three' => ['required', 'string'],
        ]);

        HomeSection::updateOrCreate(
            ['language' => $request->language],
            [
                'category_section_one' => $request->category_section_one,
                'category_section_two' => $request->category_section_two,
                'category_section_three' => $request->category_section_three,
            ]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }
}