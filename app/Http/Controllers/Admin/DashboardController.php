<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialMedia;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $publishedNews = News::where(['status' => 1, 'is_approved' => 1])->count();
        $pendingNews = News::where(['status' => 1, 'is_approved' => 0])->count();
        $categories = Category::count();
        $languages = Language::count();
        $roles = Role::count();
        $permissions = Permission::count();
        $socials = SocialMedia::count();
        $subscribers = Subscriber::count();

        return view('admin.dashboard.index', [
            'publishedNews' => $publishedNews,
            'pendingNews' => $pendingNews,
            'categories' => $categories,
            'languages' => $languages,
            'roles' => $roles,
            'permissions' => $permissions,
            'socials' => $socials,
            'subscribers' => $subscribers
        ]);
    }
}