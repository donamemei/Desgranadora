<?php

use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TipoMaizController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// ─── Ruta raíz ───────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── Rutas de autenticación (generadas por Breeze) ──────────────────
// Si no usas Breeze, estas rutas las genera: php artisan breeze:install
require __DIR__ . '/auth.php';

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
        Route::get('/',                   [ReporteController::class, 'index'])->name('index');
        Route::get('/sesion/{sesion_id}', [ReporteController::class, 'detalle'])->name('detalle');
        Route::get('/pdf/{sesion_id}',    [ReporteController::class, 'exportPDF'])->name('pdf');
        Route::get('/excel/{sesion_id}',  [ReporteController::class, 'exportExcel'])->name('excel');
    });

    // Usuarios — solo administrador
    Route::prefix('usuarios')->name('usuarios.')->middleware('rol:administrador')->group(function () {
        Route::get('/',             [UsuarioController::class, 'index'])->name('index');
        Route::get('/crear',        [UsuarioController::class, 'crear'])->name('crear');
        Route::post('/',            [UsuarioController::class, 'guardar'])->name('guardar');
        Route::get('/{id}/editar',  [UsuarioController::class, 'editar'])->name('editar');
        Route::put('/{id}',         [UsuarioController::class, 'update'])->name('update');
        Route::delete('/{id}',      [UsuarioController::class, 'destroy'])->name('destroy');
    });

    // Productores
    Route::prefix('productores')->name('productores.')->group(function () {
        Route::get('/', [ProductorController::class, 'index'])->name('index');
        Route::get('/crear', [ProductorController::class, 'create'])->name('create');
        Route::post('/', [ProductorController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [ProductorController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductorController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductorController::class, 'destroy'])->name('destroy');
    });

    // Tipos de maíz
    Route::prefix('tipos-maiz')->name('tipos-maiz.')->group(function () {
        Route::get('/', [TipoMaizController::class, 'index'])->name('index');
        Route::get('/crear', [TipoMaizController::class, 'create'])->name('create');
        Route::post('/', [TipoMaizController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [TipoMaizController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TipoMaizController::class, 'update'])->name('update');
        Route::delete('/{id}', [TipoMaizController::class, 'destroy'])->name('destroy');
    });

    // Lotes
    Route::prefix('lotes')->name('lotes.')->group(function () {
        Route::get('/', [LoteController::class, 'index'])->name('index');
        Route::get('/crear', [LoteController::class, 'create'])->name('create');
        Route::post('/', [LoteController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [LoteController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LoteController::class, 'update'])->name('update');
        Route::delete('/{id}', [LoteController::class, 'destroy'])->name('destroy');
    });

    // Clasificaciones
    Route::prefix('clasificaciones')->name('clasificaciones.')->group(function () {
        Route::get('/', [ClasificacionController::class, 'index'])->name('index');
        Route::get('/crear', [ClasificacionController::class, 'create'])->name('create');
        Route::post('/', [ClasificacionController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [ClasificacionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClasificacionController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClasificacionController::class, 'destroy'])->name('destroy');
    });

    // Alertas
    Route::prefix('alertas')->name('alertas.')->group(function () {
        Route::get('/', [AlertaController::class, 'index'])->name('index');
        Route::get('/crear', [AlertaController::class, 'create'])->name('create');
        Route::post('/', [AlertaController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [AlertaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlertaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlertaController::class, 'destroy'])->name('destroy');
    });

    // Ventas
    Route::prefix('ventas')->name('ventas.')->group(function () {
        Route::get('/', [VentaController::class, 'index'])->name('index');
        Route::get('/crear', [VentaController::class, 'create'])->name('create');
        Route::post('/', [VentaController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [VentaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VentaController::class, 'update'])->name('update');
        Route::delete('/{id}', [VentaController::class, 'destroy'])->name('destroy');
    });
});
