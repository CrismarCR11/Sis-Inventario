<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    //
    protected $fillable = [
        'uuid',
        'empresa_id',
        'local_id',
        'producto_id',
        'inventario_id',
        'tipo_movimiento',
        'cantidad',
        'stock_anterior',
        'stock_nuevo',
        'referencia_tipo',
        'referencia_id',
        'motivo',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
