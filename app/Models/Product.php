<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'uuid',
        'empresa_id',
        'categoria_id',
        'proveedor_id',
        'sku',
        'codigo_barras',
        'nombre',
        'descripcion',
        'imagen_principal_url',
        'imagenes_adicionales',
        'unidad_medida',
        'precio_compra',
        'precio_venta',
        'precio_mayoreo',
        'iva',
        'peso',
        'volumen',
        'stock_minimo',
        'stock_seguridad',
        'punto_reorden',
        'tiempo_reposicion',
        'es_compuesto',
        'activo',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function transferDetails()
    {
        return $this->hasMany(TransferDetail::class);
    }

    // public function local()
    // {
    //     return $this->belongsTo(Local::class);
    // }
}
