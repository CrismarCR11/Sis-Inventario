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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transferencia_id')->notNull();
            $table->unsignedBigInteger('producto_id')->notNull();
            $table->unsignedBigInteger('inventario_origen_id')->notNull();
            $table->integer('cantidad_solicitada')->notNull();
            $table->integer('cantidad_enviada')->default(0);
            $table->integer('cantidad_recibida')->default(0);
            $table->string('lote', 100)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->foreign('transferencia_id')->references('id')->on('transfers')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('RESTRICT');
            $table->foreign('inventario_origen_id')->references('id')->on('inventories')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_details');
    }
};
