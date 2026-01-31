<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/gestion-equipos', function () {
        return view('gestion-equipos');
    })->name('gestion-equipos');

    Route::get('/gestion-usuarios', function () {
        return view('gestion-usuarios');
    })->name('gestion-usuarios');

    Route::get('/gestion-clientes', function () {
        return view('gestion-clientes');
    })->name('gestion-clientes');
});

