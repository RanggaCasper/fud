<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/list', function () {
    return view('list');
})->name('list');

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
