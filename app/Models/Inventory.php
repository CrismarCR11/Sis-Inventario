<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    use GeneratesUuid;
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

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'stock_actual' => 'integer',
        'stock_reservado' => 'integer',
        'stock_disponible' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
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
