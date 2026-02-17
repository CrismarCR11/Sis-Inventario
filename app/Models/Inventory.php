<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $fillable = [
        'uuid',
        'producto_id',
        'local_id',
        'lote',
        'fecha_vencimiento',
        'stock_actual',
        'stock_reservado',
        'stock_disponible',
        'ubicacion_almacen',
        'ultimo_conteo',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function transferDetails()
    {
        return $this->hasMany(TransferDetail::class);
    }
}
