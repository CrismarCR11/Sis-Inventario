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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('local_id');
            $table->string('lote')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_reservado')->default(0); //pedidos pendientes
            $table->integer('stock_disponible')->default(0);
            $table->string('ubicacion_almacen')->nullable();
            $table->dateTime('ultimo_conteo')->nullable();
            $table->timestamps();
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('restrict');
            $table->unique(['producto_id', 'local_id', 'lote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
