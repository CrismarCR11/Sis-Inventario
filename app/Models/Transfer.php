<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //
    protected $fillable = [
        'uuid',
        'empresa_id',
        'local_origen_id',
        'local_destino_id',
        'numero_seguimiento',
        'fecha_solicitud',
        'fecha_envio',
        'fecha_recepcion',
        'estado',
        'observaciones',
        'usuario_solicita_id',
        'usuario_envia_id',
        'usuario_recibe_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function localOrigen()
    {
        return $this->belongsTo(Local::class, 'local_origen_id');
    }

    public function localDestino()
    {
        return $this->belongsTo(Local::class, 'local_destino_id');
    }

    public function userSolicita()
    {
        return $this->belongsTo(User::class, 'usuario_solicita_id');
    }

    public function userEnvia()
    {
        return $this->belongsTo(User::class, 'usuario_envia_id');
    }

    public function userRecibe()
    {
        return $this->belongsTo(User::class, 'usuario_recibe_id');
    }

    public function details()
    {
        return $this->hasMany(TransferDetail::class);
    }
}
