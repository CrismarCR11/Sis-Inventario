<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    use GeneratesUuid;
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

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_entrega_estimada' => 'date',
        'fecha_entrega_real' => 'date',
        'subtotal' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

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
