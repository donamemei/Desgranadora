<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agrega el campo rol a la tabla users existente de Laravel
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['administrador', 'supervisor', 'operador'])
                  ->default('operador')
                  ->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
