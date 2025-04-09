<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

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
    ->name('admin.destroy');

// ---------------------------------------
Route::get('/user', function () {
    return view('user');
})->name('user');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  ----------------- Per info shipping -----------------
Route::patch('/profile/shipping', [ProfileController::class, 'updateShipping'])
    ->name('profile.shipping.update');

require __DIR__.'/auth.php';
