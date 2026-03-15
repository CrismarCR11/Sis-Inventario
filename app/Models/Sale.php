<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    use GeneratesUuid;
    protected $fillable = [
        'uuid',
        'empresa_id',
        'local_id',
        'cliente_nombre',
        'cliente_documento',
        'numero_comprobante',
        'tipo_comprobante',
        'fecha_venta',
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_venta' => 'date',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
