<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;// নিশ্চিত করো এটা আছে
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Order;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');


// User Dashboard & Profile Routes (Middleware Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // [FIXED] এখানে আমরা শুধু Controller ব্যবহার করছি। আগের Closure Function বাদ দিয়েছি।
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order Actions
    Route::post('/orders/{id}/cancel', [DashboardController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{id}/invoice', [DashboardController::class, 'invoice'])->name('orders.invoice');

    // Profile Actions
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'store'])->name('checkout.store');
});


// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // 2. Slider Routes (Resource)
    Route::resource('sliders', SliderController::class);

    // 1. General Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');


    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    // User & Role Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__ . '/auth.php';
