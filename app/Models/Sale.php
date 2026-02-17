<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
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
