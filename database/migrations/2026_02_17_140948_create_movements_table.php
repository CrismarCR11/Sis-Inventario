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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('local_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('inventario_id')->nullable();
    
            $table->enum('tipo_movimiento', ['compra', 'venta', 'ajuste_entrada', 'ajuste_salida', 'transferencia_salida', 'transferencia_entrada', 'produccion', 'merma', 'devolucion_compra', 'devolucion_venta']);
    
            $table->integer('cantidad');
            $table->integer('stock_anterior');
            $table->integer('stock_nuevo');
    
            $table->string('referencia_tipo', 50)->nullable(); // 'App\Models\Compra', 'App\Models\Venta', etc.
            $table->unsignedBigInteger('referencia_id')->nullable();
    
            $table->text('motivo')->nullable();
            $table->unsignedBigInteger('usuario_id'); // Quién hizo el movimiento
            $table->timestamps();
    
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('restrict');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('restrict');
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('inventario_id')->references('id')->on('inventories')->onDelete('set null');
    
            $table->index('created_at');
            $table->index('referencia_tipo', 'referencia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
