<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShippingController;
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

Route::get('/vendor/editShoe', [VendorController::class, 'editShoeForm'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.editShoeForm');

Route::post('/vendor/upload', [VendorController::class, 'upload'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.upload');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::get('/admin/add', [AdminController::class, 'add'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.add');

Route::post('/admin/upload', [AdminController::class, 'save'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.save');

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
