<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BiographyController;
use App\Http\Controllers\Admin\MusicController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/locale/{locale}', function($locale) {
    Session()->put('locale', $locale);
    return redirect()->back();
})->name('language');

Route::post('/contact', [HomeController::class, 'send'])->name('contact.post');

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

Route::middleware('auth')->prefix('/admin')->group(function () {
    Route::get('/', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/', [UserController::class, 'update'])->name('user.update');

    Route::get('/musiques', [MusicController::class, 'index'])->name('music.index');
    Route::prefix('music')->group(function() {
        Route::post('/', [MusicController::class, 'store'])->name('music.store');
        Route::post('/{music:id}', [MusicController::class, 'update'])->name('music.update');
        Route::delete('/{music:id}', [MusicController::class, 'delete'])->name('music.delete');
    });

    Route::prefix('/biographie')->group(function() {
        Route::get('/', [BiographyController::class, 'index'])->name('biography.index');
        Route::post('/', [BiographyController::class, 'store'])->name('biography.store');
        Route::post('/{biography:id}', [BiographyController::class, 'update'])->name('biography.update');
        Route::delete('/{biography:id}', [BiographyController::class, 'delete'])->name('biography.delete');
    });

    Route::get('/articles', [ArticleController::class, 'index'])->name('admin.articles.index');
    Route::prefix('/article')->group(function() {
        Route::get('/nouveau', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/{article:id}', [ArticleController::class, 'show']);
        Route::get('/{article:id}/modifier', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::get('/{article:id}/traduire', [ArticleController::class, 'translate'])->name('articles.translate');
        Route::post('/{article:id}', [ArticleController::class, 'update']);
        Route::delete('/{article:id}', [ArticleController::class, 'delete'])->name('articles.delete');
    });

    Route::get('/tags/{lang}', [TagController::class, 'getTags']);
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tag', [TagController::class, 'update']);
    Route::delete('/tag/{tag:id}', [TagController::class, 'remove']);
    // ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
