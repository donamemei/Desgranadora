<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes')->cascadeOnDelete();
            $table->date('fecha_venta');
            $table->string('comprador', 120);
            $table->decimal('cantidad_kg', 10, 2);
            $table->decimal('precio_kg', 10, 2);
            $table->decimal('total', 12, 2);
            $table->string('metodo_pago', 30)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
