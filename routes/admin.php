<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\AdvertiseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AdminAuthenticationController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthenticationController::class, 'handleLogin'])->name('handle-login');
    Route::post('logout', [AdminAuthenticationController::class, 'logout'])->name('logout');

    // Reset password
    Route::get('forgot-password', [AdminAuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AdminAuthenticationController::class, 'sendResetLink'])->name('forgot-password.send');
    Route::get('reset-password/{token}', [AdminAuthenticationController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password', [AdminAuthenticationController::class, 'handleResetPassword'])->name('reset-password.send');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::resource('profile', ProfileController::class);
    Route::put('update-password/{id}', [ProfileController::class, 'updatePassword'])->name('update-password');

    // Language
    Route::resource('language', LanguageController::class);

    // Category
    Route::resource('category', CategoryController::class);

    // News
    Route::get('fetch-news-category', [NewsController::class, 'fetchCategory'])->name('fetch-news-category');
    Route::get('toggle-news-status', [NewsController::class, 'toggleNewsStatus'])->name('toggle-news-status');
    Route::get('copy-news/{id}', [NewsController::class, 'copyNews'])->name('copy-news');
    Route::get('pending-news', [NewsController::class, 'showPendingNews'])->name('pending-news.show');
    Route::put('approve-news', [NewsController::class, 'approveNews'])->name('approve-news');
    Route::resource('news', NewsController::class);

    // About
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');

    // Contact
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [ContactController::class, 'update'])->name('contact.update');

    // Home Section
    Route::get('home-section', [HomeSectionController::class, 'index'])->name('home-section.index');
    Route::put('home-section', [HomeSectionController::class, 'update'])->name('home-section.update');

    // Advertise
    Route::resource('advertise', AdvertiseController::class);

    // Message
    Route::get('message', [ContactMessageController::class, 'index'])->name('message.index');
    Route::post('message', [ContactMessageController::class, 'reply'])->name('message.reply');
    Route::delete('message/{id}/destroy', [ContactMessageController::class, 'delete'])->name('message.destroy');

    // Social Media
    Route::resource('social-media', SocialMediaController::class);

    // Subscriber
    Route::resource('subscriber', SubscriberController::class);

    // Role and Permission
    Route::get('role', [RolePermissionController::class, 'index'])->name('role.index');
    Route::get('role/create', [RolePermissionController::class, 'create'])->name('role.create');
    Route::post('role/store', [RolePermissionController::class, 'store'])->name('role.store');
    Route::get('role/{id}/edit', [RolePermissionController::class, 'edit'])->name('role.edit');
    Route::put('role/{id}/edit', [RolePermissionController::class, 'update'])->name('role.update');
    Route::delete('role/{id}/destroy', [RolePermissionController::class, 'destroy'])->name('role.destroy');

    // Admin User
    Route::resource('role-user', RoleUserController::class);

    // Setting
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('general-setting', [SettingController::class, 'updateGeneralSetting'])->name('general-setting.update');
    Route::put('seo-setting', [SettingController::class, 'updateSeoSetting'])->name('seo-setting.update');
    Route::put('appearance-setting', [SettingController::class, 'updateAppearanceSetting'])->name('appearance-setting.update');
    Route::put('translate-api-setting', [SettingController::class, 'updateTranslateApiSetting'])->name('translate-api-setting.update');

    // Localization
    Route::get('localization-admin', [LocalizationController::class, 'indexAdmin'])->name('localization-admin.index');
    Route::get('localization-frontend', [LocalizationController::class, 'indexFrontend'])->name('localization-frontend.index');
    Route::post('generate-string', [LocalizationController::class, 'generateString'])->name('generate-string');
    Route::post('update-string', [LocalizationController::class, 'updateString'])->name('update-string');
    Route::post('translate-string', [LocalizationController::class, 'translateString'])->name('translate-string');
});