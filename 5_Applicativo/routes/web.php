<?php

use Illuminate\Support\Facades\Route;

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
