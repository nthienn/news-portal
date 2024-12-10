<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsStoreRequest;
use App\Http\Requests\Admin\NewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NewsController extends Controller implements HasMiddleware
{
    use FileUploadTrait;

    public static function middleware()
    {
        return [
            new Middleware('permission:news index,admin', only: ['index', 'copyNews']),
            new Middleware('permission:news create,admin', only: ['create', 'store']),
            new Middleware('permission:news edit,admin', only: ['edit', 'update']),
            new Middleware('permission:news delete,admin', only: ['destroy']),
            new Middleware('permission:news status,admin', only: ['toggleNewsStatus'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();

        return view('admin.news.index', ['languages' => $languages]);
    }

    public function showPendingNews()
    {
        $languages = Language::all();

        return view('admin.pending-news.index', ['languages' => $languages]);
    }

    public function approveNews(Request $request)
    {
        $news = News::findOrFail($request->id);
        $news->is_approved = $request->is_approve;
        $news->save();

        return response(['status' => 'success', 'message' => __('admin.Update successfully!')]);
    }

    /**
     * Fetch category depending on language.
     */
    public function fetchCategory(Request $request)
    {
        $categories = Category::where('language', $request->language)->get();
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();

        return view('admin.news.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsStoreRequest $request)
    {
        $imagePath = $this->handleFileUpload($request, 'image');

        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->author_id = Auth::guard('admin')->user()->id;
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->is_approved = getRole() == 'Admin' || checkPermission('news all-access') ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        foreach ($tags as $tag) {
            $item = new Tag();
            $item->name = $tag;
            $item->language = $news->language;
            $item->save();

            $tagIds[] = $item->id;
        }
        $news->tags()->attach($tagIds);

        toast(__('admin.Create successfully!'), 'success');

        return redirect()->route('admin.news.index');
    }

    /**
     * Toggle status of news.
     */
    public function toggleNewsStatus(Request $request)
    {
        $new = News::findOrFail($request->id);
        $new->{$request->name} = $request->status;
        $new->save();

        return response(['status' => 'success', 'message' => __('admin.Update successfully!')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $news = News::findOrFail($id);

        if (!canAccess('news all-access')) {
            if ($news->author_id != auth()->guard('admin')->user()->id) {
                return abort(404);
            }
        }

        $categories = Category::where('language', $news->language)->get();

        return view('admin.news.edit', [
            'languages' => $languages,
            'news' => $news,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsUpdateRequest $request, string $id)
    {
        $news = News::findOrFail($id);

        if ($news->author_id != auth()->guard('admin')->user()->id || getRole() != 'Admin') {
            return abort(404);
        }

        $imagePath = $this->handleFileUpload($request, 'image');

        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ? $imagePath : $news->image;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        // delete previous tags
        $news->tags()->delete();
        // detach tags from pivot table
        $news->tags()->detach($news->tags);

        foreach ($tags as $tag) {
            $item = new Tag();
            $item->name = $tag;
            $item->language = $news->language;
            $item->save();

            $tagIds[] = $item->id;
        }
        $news->tags()->attach($tagIds);

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $news = News::findOrFail($id);
            $this->deleteFile($news->image);
            $news->tags()->delete();
            $news->delete();
            return response(['status' => 'success', 'message' => __('admin.Delete successfully!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Copy news.
     */
    public function copyNews(string $id)
    {
        $news = News::findOrFail($id);
        $copyNews = $news->replicate();
        $copyNews->save();

        toast(__('admin.Copy successfully!'), 'success');

        return redirect()->back();
    }
}