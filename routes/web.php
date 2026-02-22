<?php

use Illuminate\Support\Facades\Route;



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class , 'index'])->name('home');

    // Estadísticas: acceso controlado por ReporteController (soporte bloqueado).
    Route::get('/estadisticas', [\App\Http\Controllers\ReporteController::class , 'index'])->name('estadisticas');
    // PDF imprimible de las estadísticas (usa los mismos parámetros que el dashboard)
    Route::get('/estadisticas/pdf', [\App\Http\Controllers\ReporteController::class , 'pdf'])->name('estadisticas.pdf');
    Route::get('/api/reportes/data', [\App\Http\Controllers\ReporteController::class , 'getData'])->name('reportes.data');

    // Gestión de usuarios y auditoría: administrador y supervisor
    Route::middleware('role:administrador,supervisor')->group(function () {
        Route::get('/gestion-usuarios', [\App\Http\Controllers\UserController::class , 'index'])->name('gestion-usuarios');
        Route::post('/users/save', [\App\Http\Controllers\UserController::class , 'saveUser'])->name('users.save');
        Route::post('/users/update', [\App\Http\Controllers\UserController::class , 'updateUser'])->name('users.update');
        Route::get('/users/search/{email}', [\App\Http\Controllers\UserController::class , 'findByEmail'])->name('users.search');

        Route::get('/gestion-auditoria', [\App\Http\Controllers\AuditoriaController::class, 'index'])->name('gestion-auditoria');
        Route::get('/api/auditoria/data', [\App\Http\Controllers\AuditoriaController::class, 'getData'])->name('auditoria.data');
    });

    // Páginas de listado (permitir ver por recepcionista, supervisor, administrador)
    Route::middleware('role:recepcionista,supervisor,administrador')->group(function () {
        Route::get('/gestion-clientes', [\App\Http\Controllers\ClienteController::class , 'index'])->name('gestion-clientes');
        Route::get('/gestion-equipos', [\App\Http\Controllers\EquipoController::class , 'index'])->name('gestion-equipos');
        Route::get('/gestion-casos', [\App\Http\Controllers\CasoController::class , 'index'])->name('gestion-casos');
    });

    // Rutas que requieren ser recepcionista
    Route::middleware('role:recepcionista')->group(function () {
        // Clientes
        Route::post('/clientes/save', [\App\Http\Controllers\ClienteController::class , 'saveCliente'])->name('clientes.save');
        Route::post('/clientes/update', [\App\Http\Controllers\ClienteController::class , 'updateCliente'])->name('clientes.update');
        // Equipos
        Route::post('/equipos/save', [\App\Http\Controllers\EquipoController::class , 'saveEquipo'])->name('equipos.save');
        Route::post('/equipos/update', [\App\Http\Controllers\EquipoController::class , 'updateEquipo'])->name('equipos.update');
        // Casos
        Route::post('/casos/save', [\App\Http\Controllers\CasoController::class , 'saveCaso'])->name('casos.save');
        // Recepción / Salida
        Route::post('/recepcion/save', [\App\Http\Controllers\RecepcionController::class , 'saveRecepcion'])->name('recepcion.save');
        Route::post('/recepcion/update', [\App\Http\Controllers\RecepcionController::class , 'updateRecepcion'])->name('recepcion.update');
        Route::post('/recepcion/salida', [\App\Http\Controllers\RecepcionController::class , 'registrarSalida'])->name('recepcion.salida');
    });

    // documentar caso: tanto recepcionista como soporte (controlador valida)
    Route::post('/casos/documentar', [\App\Http\Controllers\CasoController::class , 'documentarCaso'])->name('casos.documentar');

    // Rutas abiertas a roles variados pero con chequeos internos en controladores
    Route::post('/casos/update', [\App\Http\Controllers\CasoController::class , 'updateCaso'])->name('casos.update');
    Route::get('/casos/search/{id}', [\App\Http\Controllers\CasoController::class , 'findById'])->name('casos.search');
    Route::get('/casos/disponibles', [\App\Http\Controllers\CasoController::class , 'getCasosDisponibles'])->name('casos.disponibles');
    Route::get('/tecnicos/all', [\App\Http\Controllers\CasoController::class , 'getTecnicos'])->name('tecnicos.all');
    Route::post('/casos/asignar-tecnico', [\App\Http\Controllers\CasoController::class , 'asignarTecnico'])->name('casos.asignar-tecnico')->middleware('role:administrador,supervisor');
    Route::get('/casos/asignados', [\App\Http\Controllers\CasoController::class , 'getCasosAsignados'])->name('casos.asignados');
    Route::get('/piezas', [\App\Http\Controllers\CasoController::class , 'getPiezas'])->name('piezas.index');

    // Rutas para equipos y recepciones de consulta pública (ya protegidas arriba)
    Route::get('/equipos/search/{serial}', [\App\Http\Controllers\EquipoController::class , 'findBySerial'])->name('equipos.search');
    Route::get('/equipos/all', [\App\Http\Controllers\EquipoController::class , 'getAllEquipos'])->name('equipos.all');
    Route::get('/recepcion/search/{id_caso}', [\App\Http\Controllers\RecepcionController::class , 'findByCaso'])->name('recepcion.search');
    Route::get('/recepcion/all', [\App\Http\Controllers\RecepcionController::class , 'getAllPaged'])->name('recepcion.all');
    Route::get('/salida/all', [\App\Http\Controllers\RecepcionController::class , 'getSalidasPaged'])->name('salida.all');
    // reporte imprimible / PDF de todas las recepciones de equipo
    Route::get('/recepcion/pdf', [\App\Http\Controllers\RecepcionController::class, 'pdf'])->name('recepcion.pdf');
    // PDF imprimible de las salidas de equipo
    Route::get('/salidas/pdf', [\App\Http\Controllers\RecepcionController::class, 'pdfSalidas'])->name('salidas.pdf');
});
