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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('local_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->string('numero_orden', 100)->nullable();
            $table->string('numero_factura', 100)->nullable();
            $table->date('fecha_compra')->notNull();
            $table->date('fecha_entrega_estimada')->nullable();
            $table->date('fecha_entrega_real')->nullable();
            $table->enum('estado', ['pendiente', 'aprobada', 'enviada', 'parcial', 'recibida', 'anulada'])->default('pendiente');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuesto', 12, 2);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_id')->notNull();
            $table->timestamps();
    
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('restrict');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('restrict');
            $table->foreign('proveedor_id')->references('id')->on('providers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
