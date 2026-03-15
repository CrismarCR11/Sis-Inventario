<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use GeneratesUuid;
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

    protected $casts = [
        'imagenes_adicionales' => 'array',
        'es_compuesto' => 'boolean',
        'activo' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

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
        return $this->hasMany(Inventory::class, 'producto_id');
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
