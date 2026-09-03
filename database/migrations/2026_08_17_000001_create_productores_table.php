<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('municipio')->default('Ucureña');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productores');
    }
};
