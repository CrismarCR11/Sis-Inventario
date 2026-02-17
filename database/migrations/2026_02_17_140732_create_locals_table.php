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
        Schema::create('locals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->enum('tipo', ['principal', 'sucursal', 'almacen', 'punto_venta'])->default('sucursal');
            $table->text('direccion');
            $table->string('ciudad');
            $table->string('telefono');
            $table->string('email');
            $table->decimal('capacidad_maxima', 12, 2)->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
