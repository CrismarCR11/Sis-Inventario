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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->enum('tipo_documento', ['RUC', 'DNI', 'PASAPORTE', 'OTRO'])->default('RUC');
            $table->string('numero_documento');
            $table->string('nombre_razon_social');
            $table->string('nombre_comercial');
            $table->string('email');
            $table->string('telefono');
            $table->text('direccion');
            $table->string('contacto_nombre');
            $table->string('contacto_telefono');
            $table->string('contacto_email');
            $table->integer('dias_entrega_promedio')->default(3); //Para reorden automático
            $table->boolean('activo')->default(true);
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('restrict');
            $table->unique(['empresa_id', 'tipo_documento', 'numero_documento']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
