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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->string('sku')->unique(); // SKU único por empresa
            $table->string('codigo_barras')->nullable();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen_principal_url')->nullable();
            $table->json('imagenes_adicionales')->nullable();
            $table->string('unidad_medida')->default('unidad'); // unidad, kg, litro, caja, etc.
            $table->decimal('precio_compra', 12, 2)->default(0.00);
            $table->decimal('precio_venta', 12, 2)->default(0.00);
            $table->decimal('precio_mayoreo', 12, 2)->nullable();
            $table->integer('cantidad_mayoreo_desde')->nullable();
            $table->decimal('iva', 5, 2)->default(18.00);
            $table->decimal('peso', 10, 3)->nullable();
            $table->decimal('volumen', 10, 3)->nullable();
            //atrib inventario
            $table->integer('stock_minimo')->default(0); //alerta
            $table->integer('stock_seguridad')->default(0); //stock de seguridad
            $table->integer('punto_reorden')->default(0); //punto de reorden
            $table->integer('tiempo_reposicion')->default(3); //dias
            $table->boolean('es_compuesto')->default(false); // Para kits/recetas
            $table->boolean('activo')->default(true); // Activo
            $table->timestamps();
            $table->foreign('empresa_id')->references('id')->on('companies')->onDelete('restrict');
            $table->foreign('categoria_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('proveedor_id')->references('id')->on('providers')->onDelete('set null');
            $table->unique(['empresa_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
