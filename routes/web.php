<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PasswordController;
use App\Http\Controllers\Admin\UserPasswordController;
use App\Http\Controllers\Frontend\OrderHistoryController;
use App\Http\Controllers\Frontend\CustomerProfileController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{item}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Order history
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');

    // Customer profile
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    // Ubah password
    Route::get('/profile/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');
});

Route::get('/dashboard', function () {
    // Kalau mau setelah login biasa ke halaman katalog:
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// ADMIN AREA
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |---------------------------------------------------------
        | ADMIN & SELLER
        |---------------------------------------------------------
        */
        Route::middleware('role:admin,seller')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('items', AdminItemController::class);
            Route::resource('categories', AdminCategoryController::class)->except(['show']);
            Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

            Route::get('store-profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::put('store-profile', [AdminProfileController::class, 'update'])->name('profile.update');
        });

        /*
        |---------------------------------------------------------
        | HANYA ADMIN
        |---------------------------------------------------------
        */
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);

            Route::get('users/{user}/password', [UserPasswordController::class, 'edit'])
                ->name('users.password.edit');

            Route::put('users/{user}/password', [UserPasswordController::class, 'update'])
                ->name('users.password.update');
        });
    });

require __DIR__ . '/auth.php';
