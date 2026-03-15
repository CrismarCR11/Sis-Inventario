<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->char('uuid', 36)->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('local_origen_id');
            $table->unsignedBigInteger('local_destino_id');
            $table->string('numero_seguimiento', 100)->nullable();
            $table->datetime('fecha_solicitud');
            $table->datetime('fecha_envio')->nullable();
            $table->datetime('fecha_recepcion')->nullable();
            $table->enum('estado', ['pendiente', 'enviada', 'recibida', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_solicita_id');
            $table->unsignedBigInteger('usuario_envia_id')->nullable();
            $table->unsignedBigInteger('usuario_recibe_id')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('restrict');
            $table->foreign('local_origen_id')->references('id')->on('locals')->onDelete('restrict');
            $table->foreign('local_destino_id')->references('id')->on('locals')->onDelete('restrict');
            
            // Índices
            $table->index('uuid');
            $table->index('estado');
            $table->index('fecha_solicitud');
            
            // IMPORTANTE: El DB::statement NO VA AQUÍ
        });

        // AHORA SÍ, después de crear la tabla, agregamos el constraint CHECK
        DB::statement('
            ALTER TABLE transfers 
            ADD CONSTRAINT transfers_origen_destino_check 
            CHECK (local_origen_id != local_destino_id)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Es buena práctica eliminar el constraint antes de borrar la tabla
        DB::statement('ALTER TABLE transfers DROP CONSTRAINT IF EXISTS transfers_origen_destino_check');
        Schema::dropIfExists('transfers');
    }
};