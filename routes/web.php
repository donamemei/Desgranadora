<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// ─── Ruta raíz ───────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── Rutas de autenticación (generadas por Breeze) ──────────────────
// Si no usas Breeze, estas rutas las genera: php artisan breeze:install
require __DIR__.'/auth.php';

// ─── Rutas protegidas (requieren login) ─────────────────────────────
Route::middleware('auth')->group(function () {

    // Estadísticas generales
Route::get('/estadisticas', [App\Http\Controllers\EstadisticasController::class, 'index'])
    ->name('estadisticas.index');

// Historial de sesiones
Route::get('/historial', [App\Http\Controllers\HistorialController::class, 'index'])
    ->name('historial.index');

// Info de la máquina
Route::get('/maquina', [App\Http\Controllers\MaquinaController::class, 'index'])
    ->name('maquina.index');

// Manual de uso
Route::get('/manual', [App\Http\Controllers\ManualController::class, 'index'])
    ->name('manual.index');

// Acerca del proyecto
Route::get('/acerca', [App\Http\Controllers\AcercaController::class, 'index'])
    ->name('acerca.index');

// Contacto
Route::get('/contacto', [App\Http\Controllers\ContactoController::class, 'index'])
    ->name('contacto.index');

    // Dashboard — todos los roles tienen acceso
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Reportes — solo administrador y supervisor
    Route::prefix('reportes')->name('reportes.')->middleware('rol:administrador,supervisor')->group(function () {
        Route::get('/',                   [ReporteController::class, 'index'])       ->name('index');
        Route::get('/sesion/{sesion_id}', [ReporteController::class, 'detalle'])     ->name('detalle');
        Route::get('/pdf/{sesion_id}',    [ReporteController::class, 'exportPDF'])   ->name('pdf');
        Route::get('/excel/{sesion_id}',  [ReporteController::class, 'exportExcel']) ->name('excel');
    });

    // Usuarios — solo administrador
    Route::prefix('usuarios')->name('usuarios.')->middleware('rol:administrador')->group(function () {
        Route::get('/',             [UsuarioController::class, 'index'])   ->name('index');
        Route::get('/crear',        [UsuarioController::class, 'crear'])   ->name('crear');
        Route::post('/',            [UsuarioController::class, 'guardar']) ->name('guardar');
        Route::get('/{id}/editar',  [UsuarioController::class, 'editar'])  ->name('editar');
        Route::put('/{id}',         [UsuarioController::class, 'update'])  ->name('update');
        Route::delete('/{id}',      [UsuarioController::class, 'destroy']) ->name('destroy');
    });

});
