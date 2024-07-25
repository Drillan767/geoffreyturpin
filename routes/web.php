<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/locale/{locale}', function($locale) {
    Session()->put('locale', $locale);
    return redirect()->back();
})->name('language');

Route::localized(function() {
    Route::get('/', [HomeController::class, 'landing'])->name('home');
    Route::get(__('routes.legal'), [HomeController::class, 'legal'])->name('legal');
    Route::get(__('routes.biography'), [HomeController::class, 'biography'])->name('biography');
    Route::get(__('routes.music'), [HomeController::class, 'music'])->name('musics');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/articles', [PostController::class, 'index'])->name('articles');
    Route::get('/article/{slug}', [PostController::class, 'show'])->name('article.show');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
