<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\RoleController;

// PUBLIC ROUTES

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/info/{slug}', [PageViewController::class, 'show'])->name('page.view');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track.index');
Route::post('/track-order', [TrackOrderController::class, 'search'])->name('track.search');
Route::get('/lang/{lang}', [HomeController::class, 'switchLanguage'])->name('lang.switch');


// CART ROUTES

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',        [CartController::class, 'index'])->name('index');
    Route::post('/add',    [CartController::class, 'store'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'destroy'])->name('remove');
    Route::patch('/update/{id}',  [CartController::class, 'update'])->name('update');
});

//  USER ROUTES (Auth Required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/orders/{id}/cancel', [DashboardController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{id}/invoice', [DashboardController::class, 'invoice'])->name('orders.invoice');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'store'])->name('checkout.store');

    // Wishlist & Reviews
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


//  ADMIN ROUTES (Role & Permission Protected)
Route::middleware(['auth', 'role:super-admin|manager|admin']) 
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Categories (Permission Protected)
        Route::resource('categories', CategoryController::class);

        // Products (Permission Protected)
        Route::resource('products', ProductController::class);

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

        // Users & Roles (Only Super Admin Should Access ideally, or check permission)
        Route::resource('users', UserController::class);
        Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.update-role');

        // Role Management
        Route::resource('roles', RoleController::class);

        // Sliders & Pages
        Route::resource('sliders', SliderController::class);
        Route::resource('pages', PageController::class);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Contact Messages
        Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [ContactMessageController::class, 'show'])->name('contacts.show');
        Route::post('/contacts/{id}/reply', [ContactMessageController::class, 'reply'])->name('contacts.reply');
        Route::delete('/contacts/{id}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');
    });

require __DIR__ . '/auth.php';
