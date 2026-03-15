<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    //
    protected $fillable = [
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

    protected $casts = [
        'cantidad' => 'integer',
        'cantidad_recibida' => 'integer',
        'precio_unitario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'fecha_vencimiento' => 'date',
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
