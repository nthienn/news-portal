<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageStoreRequest;
use App\Http\Requests\Admin\LanguageUpdateRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LanguageController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:language index,admin', only: ['index']),
            new Middleware('permission:language create,admin', only: ['create', 'store']),
            new Middleware('permission:language edit,admin', only: ['edit', 'update']),
            new Middleware('permission:language delete,admin', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();

        return view('admin.language.index', ['languages' => $languages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageStoreRequest $request)
    {
        Language::create($request->validated());

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.language.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        return view('admin.language.edit', ['language' => $language]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageUpdateRequest $request, string $id)
    {
        $language = Language::findOrFail($id);
        $language->update($request->validated());

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->route('admin.language.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        try {
            if ($language->language === 'en') {
                return response(['status' => 'error', 'message' => __("admin.Can't delete this one!")]);
            }
            $language->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}