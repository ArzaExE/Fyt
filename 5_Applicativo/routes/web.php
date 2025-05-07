<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/vendor', [VendorController::class, 'index'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor');

Route::get('/vendor/add', [VendorController::class, 'add'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.add');

Route::get('/vendor/edit/{product}', [VendorController::class, 'edit'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.edit');

Route::post('/vendor/upload', [VendorController::class, 'upload'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.upload');

Route::put('/vendor/save/{product}', [VendorController::class, 'save'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.save');

Route::delete('/admin/delete/{product}', [VendorController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.destroy');

//------------- Pagine admin -------------

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::get('/admin/edit/{user}', [AdminController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.edit');

Route::put('/admin/save/{user}', [AdminController::class, 'save'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.save');

Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.destroy');

//------------------------------------------
Route::get('/catalog', [CatalogController::class, 'index'])
    ->name('catalog');

Route::get('/catalog/product/{id}', [ProductController::class, 'get'])
    ->name('product.get');

// ---------- Pagine Carrello -------------
Route::get('/cart', [CartController::class, 'index'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('cart.add');

Route::post('/cart/remove/{product}', [CartController::class, 'remove'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('cart.remove');

Route::post('/cart/delete/{product}', [CartController::class, 'delete'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('cart.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  ----------------- Per info shipping -----------------
Route::patch('/profile/shipping', [ProfileController::class, 'updateShipping'])
    ->name('profile.shipping.update');

require __DIR__.'/auth.php';

//  ----------------- Per prodotti venduti -----------------
Route::middleware('auth')->group(function () {
    Route::get('/vendor/sales', [VendorController::class, 'showSales'])->name('vendor.sales');
});
Route::get('/vendor/sales', [VendorController::class, 'showSales'])->name('vendor.sales');
