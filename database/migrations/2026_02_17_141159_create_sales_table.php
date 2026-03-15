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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('local_id');
            $table->string('cliente_nombre', 255)->nullable();
            $table->string('cliente_documento', 20)->nullable();
            $table->string('numero_comprobante', 100)->nullable();
            $table->enum('tipo_comprobante', ['boleta', 'factura', 'ticket', 'nota_credito'])->default('boleta');
            $table->datetime('fecha_venta');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuesto', 12, 2);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->enum('estado', ['completada', 'anulada', 'pendiente_pago'])->default('completada');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('RESTRICT');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
