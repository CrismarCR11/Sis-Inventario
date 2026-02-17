<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'empresa_id',
        'padre_id',
        'nombre',
        'slug',
        'descripcion',
        'imagen_url',
        'orden',
        'activo',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'padre_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'padre_id');
    }

    public function locals()
    {
        return $this->belongsToMany(Local::class, 'local_categories', 'categoria_id', 'local_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
