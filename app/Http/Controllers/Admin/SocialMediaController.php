<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialMediaStoreRequest;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SocialMediaController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:social media index,admin', only: ['index']),
            new Middleware('permission:social media create,admin', only: ['create', 'store']),
            new Middleware('permission:social media edit,admin', only: ['edit', 'update']),
            new Middleware('permission:social media delete,admin', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socials = SocialMedia::all();

        return view('admin.social-media.index', ['socials' => $socials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social-media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialMediaStoreRequest $request)
    {
        SocialMedia::create($request->validated());

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.social-media.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $social = SocialMedia::findOrFail($id);

        return view('admin.social-media.edit', ['social' => $social]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialMediaStoreRequest $request, string $id)
    {
        $social = SocialMedia::findOrFail($id);
        $social->update($request->validated());

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->route('admin.social-media.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $social = SocialMedia::findOrFail($id);
            $social->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}