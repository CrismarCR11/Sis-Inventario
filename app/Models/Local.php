<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    //
    use GeneratesUuid;
    protected $fillable = [
        'uuid',
        'empresa_id',
        'codigo',
        'nombre',
        'tipo',
        'direccion',
        'ciudad',
        'telefono',
        'email',
        'capacidad_maxima',
        'activo',
    ];

    protected $casts = [
        'capacidad_maxima' => 'integer',
        'activo' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
