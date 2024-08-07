<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/form', function () {
    return view('form');
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/beranda', [App\Http\Controllers\DashboardController::class, 'index'])->name('beranda');
Route::get('/form', [App\Http\Controllers\FormController::class, 'index'])->name('form');

Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');

Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('roles', App\Http\Controllers\RoleController::class);
