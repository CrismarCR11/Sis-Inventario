<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = [
        'uuid',
        'empresa_id',
        'local_id',
        'proveedor_id',
        'numero_orden',
        'numero_factura',
        'fecha_compra',
        'fecha_entrega_estimada',
        'fecha_entrega_real',
        'estado',
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'observaciones',
        'usuario_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
