<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('ruc')->unique();
            $table->string('razon_social');
            $table->string('nombre_comercial');
            $table->string('email');
            $table->string('telefono');
            $table->text('direccion');
            $table->string('logo_url');
            $table->json('configuracion'); //Almacena settings generales (moneda, huso horario)
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
