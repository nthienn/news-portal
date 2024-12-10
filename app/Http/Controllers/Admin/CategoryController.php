<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:category index,admin', only: ['index']),
            new Middleware('permission:category create,admin', only: ['create', 'store']),
            new Middleware('permission:category edit,admin', only: ['edit', 'update']),
            new Middleware('permission:category delete,admin', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        $categories = Category::all();

        return view('admin.category.index', ['languages' => $languages, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();

        return view('admin.category.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = \Str::slug($request->name);

        Category::create($data);

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $languages = Language::all();

        return view('admin.category.edit', ['category' => $category, 'languages' => $languages]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $data['slug'] = \Str::slug($request->name);

        $category = Category::findOrFail($id);
        $category->update($data);

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}