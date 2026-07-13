<?php

use App\Http\Controllers\Api\LecturaController;
use Illuminate\Support\Facades\Route;

/*
 * Estos endpoints son consumidos por:
 *   - El Arduino (via ESP8266 WiFi) → POST /api/lectura
 *   - El dashboard JavaScript        → GET  /api/lectura/ultimo
 *   - Los reportes                   → GET  /api/lectura/sesion/{id}
 */

// El Arduino envía datos aquí cada 2 segundos
Route::post('/lectura',                 [LecturaController::class, 'store']);

// El dashboard JS llama aquí cada 2 segundos para actualizar la pantalla
Route::get('/lectura/ultimo',           [LecturaController::class, 'ultimo']);

// Datos históricos de una sesión completa (reportes y gráficas históricas)
Route::get('/lectura/sesion/{sesionId}',[LecturaController::class, 'porSesion']);

// Lista de todas las sesiones (para la pantalla de Reportes)
Route::get('/sesiones',                 [LecturaController::class, 'sesiones']);