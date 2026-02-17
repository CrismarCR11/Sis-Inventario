<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //
    protected $fillable = [
        'uuid',
        'empresa_id',
        'tipo_documento',
        'numero_documento',
        'nombre_razon_social',
        'nombre_comercial',
        'email',
        'telefono',
        'direccion',
        'contacto_nombre',
        'contacto_telefono',
        'contacto_email',
        'dias_entrega_promedio',
        'activo',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
