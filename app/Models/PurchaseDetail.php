<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    //
    protected $fillable = [
        'uuid',
        'compra_id',
        'producto_id',
        'cantidad',
        'cantidad_recibida',
        'precio_unitario',
        'descuento',
        'subtotal',
        'lote',
        'fecha_vencimiento',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
