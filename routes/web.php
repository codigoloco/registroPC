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

    Route::get('/gestion-equipos', [\App\Http\Controllers\EquipoController::class, 'index'])->name('gestion-equipos');

    Route::get('/gestion-usuarios', [\App\Http\Controllers\UserController::class, 'index'])->name('gestion-usuarios');

    Route::get('/gestion-clientes', [\App\Http\Controllers\ClienteController::class, 'index'])->name('gestion-clientes');

    Route::get('/gestion-casos', [\App\Http\Controllers\CasoController::class, 'index'])->name('gestion-casos');

    Route::get('/gestion-auditoria', function () {
        return view('gestion-auditoria');
    })->name('gestion-auditoria');

    // Rutas para Equipos
    Route::post('/equipos/save', [\App\Http\Controllers\EquipoController::class, 'saveEquipo'])->name('equipos.save');
    Route::post('/equipos/update', [\App\Http\Controllers\EquipoController::class, 'updateEquipo'])->name('equipos.update');
    Route::get('/equipos/search/{serial}', [\App\Http\Controllers\EquipoController::class, 'findBySerial'])->name('equipos.search');

    // Rutas para Recepción
    Route::post('/recepcion/save', [\App\Http\Controllers\RecepcionController::class, 'saveRecepcion'])->name('recepcion.save');
    Route::post('/recepcion/update', [\App\Http\Controllers\RecepcionController::class, 'updateRecepcion'])->name('recepcion.update');
    Route::post('/recepcion/salida', [\App\Http\Controllers\RecepcionController::class, 'registrarSalida'])->name('recepcion.salida');
    Route::get('/recepcion/search/{id_caso}', [\App\Http\Controllers\RecepcionController::class, 'findByCaso'])->name('recepcion.search');
    Route::get('/recepcion/all', [\App\Http\Controllers\RecepcionController::class, 'getAllPaged'])->name('recepcion.all');
    Route::get('/salida/all', [\App\Http\Controllers\RecepcionController::class, 'getSalidasPaged'])->name('salida.all');

    // Rutas para Usuarios
    Route::post('/users/save', [\App\Http\Controllers\UserController::class, 'saveUser'])->name('users.save');
    Route::post('/users/update', [\App\Http\Controllers\UserController::class, 'updateUser'])->name('users.update');
    Route::get('/users/search/{email}', [\App\Http\Controllers\UserController::class, 'findByEmail'])->name('users.search');

    // Rutas para Clientes
    Route::post('/clientes/save', [\App\Http\Controllers\ClienteController::class, 'saveCliente'])->name('clientes.save');
    Route::post('/clientes/update', [\App\Http\Controllers\ClienteController::class, 'updateCliente'])->name('clientes.update');
    Route::get('/clientes/search/{id}', [\App\Http\Controllers\ClienteController::class, 'findById'])->name('clientes.search');

    // Rutas para Casos
    Route::post('/casos/save', [\App\Http\Controllers\CasoController::class, 'saveCaso'])->name('casos.save');
    Route::post('/casos/update', [\App\Http\Controllers\CasoController::class, 'updateCaso'])->name('casos.update');
    Route::post('/casos/documentar', [\App\Http\Controllers\CasoController::class, 'documentarCaso'])->name('casos.documentar');
    Route::get('/casos/search/{id}', [\App\Http\Controllers\CasoController::class, 'findById'])->name('casos.search');
    Route::get('/piezas', [\App\Http\Controllers\CasoController::class, 'getPiezas'])->name('piezas.index');
});

