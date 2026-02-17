<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    //
    protected $fillable = [
        'uuid',
        'transferencia_id',
        'producto_id',
        'inventario_origen_id',
        'cantidad_solicitada',
        'cantidad_enviada',
        'cantidad_recibida',
        'lote',
        'fecha_vencimiento',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventoryOrigin()
    {
        return $this->belongsTo(Inventory::class, 'inventario_origen_id');
    }
}
