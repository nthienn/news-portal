<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('language', LanguageController::class)->name('language');

// News Detail
Route::get('news-detail/{slug}', [HomeController::class, 'showNewsDetail'])->name('news-detail');

// News
Route::get('news', [HomeController::class, 'showNews'])->name('news');

// About
Route::get('about', [HomeController::class, 'about'])->name('about');

// Contact
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::post('contact', [HomeController::class, 'handleContact'])->name('contact.send');

// News Comments
Route::post('news-comment', [HomeController::class, 'handleComment'])->name('news-comment');
Route::post('news-comment-reply', [HomeController::class, 'handleCommentReply'])->name('news-comment-reply');
Route::delete('news-comment-delete', [HomeController::class, 'handleCommentDelete'])->name('news-comment-delete');

// Newsletter
Route::post('subscribe-newsletter', [HomeController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');