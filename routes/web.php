<?php

use App\Http\Controllers\Blog\BlogPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/shop', function () {
        return Inertia::render('Shop/Products');
    })->name('shop');

    Route::get('/products',[ProductController::class, 'index']);
    Route::get('/promoted-products',[ProductController::class, 'getPromoted']);
    Route::get('/product/{id}', [ProductController::class, 'details'])->name('product.details');

    Route::get('/blog', function () {
        return Inertia::render('Blog/Posts');
    })->name('blog');
    Route::get('/posts',[BlogPostController::class, 'index']);
    Route::get('/post/{id}', [BlogPostController::class, 'details'])->name('post.details');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
