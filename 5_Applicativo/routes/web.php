<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/catalog', function () {
    return view('catalog');
});

Route::get('/shoe', function () {
    return view('shoe');
});

Route::get('/products', function () {
    return view('product');
});

Route::get('/vendor', function () {
    return view('vendor');
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/vendor', [VendorController::class, 'index']);

