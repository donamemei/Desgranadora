<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla que almacena cada lectura enviada por el Arduino.
     * Se inserta un registro cada ~2 segundos mientras el motor está en ON.
     */
    public function up(): void
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();

            // Datos del sensor de velocidad (efecto Hall)
            $table->float('rpm')->default(0);

            // Datos de la celda de carga (peso acumulado en la sesión)
            $table->float('kg_procesados')->default(0);

            // Productividad calculada por el Arduino: (kg / minutos) * 60
            $table->float('kg_hora')->default(0);

            // Temperatura del motor en °C (si hay sensor). Null si no hay sensor.
            $table->float('temperatura')->nullable();

            // Estado del motor: 'ON', 'OFF', 'ALERTA'
            $table->string('estado_motor', 10)->default('OFF');

            // Identificador de sesión — el Arduino lo genera al encender
            // Formato: SES-AAAAMMDD-NNN  (ej: SES-20241015-001)
            $table->string('sesion_id', 30)->nullable()->index();

            // Laravel maneja created_at y updated_at automáticamente
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturas');
    }
};
