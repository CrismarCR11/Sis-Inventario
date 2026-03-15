<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'nombre_comercial' => $this->nombre_comercial,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'logo_url' => $this->logo_url,
            'configuracion' => $this->configuracion,
            'activo' => $this->activo,
            'locales_count' => $this->whenLoaded('locales', fn() => $this->locales->count()),
            'locales' => LocalResource::collection($this->whenLoaded('locales')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}