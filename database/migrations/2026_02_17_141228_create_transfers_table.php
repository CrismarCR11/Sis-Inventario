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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique()->notNull();
            $table->unsignedBigInteger('empresa_id')->notNull();
            $table->unsignedBigInteger('local_origen_id')->notNull();
            $table->unsignedBigInteger('local_destino_id')->notNull();
            $table->string('numero_seguimiento', 100)->nullable();
            $table->datetime('fecha_solicitud')->notNull();
            $table->datetime('fecha_envio')->nullable();
            $table->datetime('fecha_recepcion')->nullable();
            $table->enum('estado', ['pendiente', 'enviada', 'recibida', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_solicita_id')->notNull();
            $table->unsignedBigInteger('usuario_envia_id')->nullable();
            $table->unsignedBigInteger('usuario_recibe_id')->nullable();
            $table->timestamps();
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->foreign('local_origen_id')->references('id')->on('locals')->onDelete('RESTRICT');
            $table->foreign('local_destino_id')->references('id')->on('locals')->onDelete('RESTRICT');
            $table->check('local_origen_id != local_destino_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
