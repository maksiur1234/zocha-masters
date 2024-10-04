<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Blog\BlogPostController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\Stripe\StripeController;
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

    Route::get('/add-post', [BlogPostController::class, 'newPost'])->name('addPost');
    Route::post('/store-post', [BlogPostController::class, 'store'])->name('storePost');
    Route::get('/posts',[BlogPostController::class, 'index']);
    Route::get('/post/{id}', [BlogPostController::class, 'details'])->name('post.details');

    Route::get('/cart',[CartController::class, 'index'])->name('cart');
    Route::get('/cart-data',[CartController::class, 'data'])->name('cartData');
    Route::post('/cart/add',[CartController::class, 'add']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'delete']);
    
    Route::get('/place-order-address', [OrderController::class, 'addressForm']);
    Route::get('/place-order-delivery', [OrderController::class, 'deliveryForm']);

    Route::get('/place-order-payment', [PaymentController::class, 'index'])->name('payment-index');

    Route::post('/store-address', [AddressController::class, 'store']);

    Route::get('/success', [StripeController::class, 'checkout'])->name('success');
    Route::post('/checkout', [StripeController::class, 'checkout'])->name('checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
