<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    use GeneratesUuid;
    protected $fillable = [
        'uuid',
        'ruc',
        'razon_social',
        'nombre_comercial',
        'email',
        'telefono',
        'direccion',
        'logo_url',
        'configuracion',
        'activo',
    ];

    protected $casts = [
        'configuracion' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function locals()
    {
        return $this->hasMany(Local::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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
