<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/vendor', [VendorController::class, 'index'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor');

Route::get('/vendor/add', [VendorController::class, 'add'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.add');

Route::post('/vendor/upload', [VendorController::class, 'upload'])
    ->middleware(['auth', 'verified', 'vendor'])
    ->name('vendor.upload');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// DA CAMBIARE CON ADMIN
Route::get('/admin', function () {
    return view('admin');
})->name('admin');

// per utente base
Route::get('/user', function () {
    return view('user');
})->name('user');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
