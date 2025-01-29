<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\produkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/{id}/process', [AdminController::class, 'processOrder'])->name('admin.orders.process');
});

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/admin/orders/{order}/process', [OrderController::class, 'process'])->name('admin.orders.process');

Route::get('/search', [produkController::class, 'search']);

require __DIR__.'/auth.php';
