<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductoResource;
use App\Http\Resources\LocalResource;

class InventoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'producto' => new ProductoResource($this->whenLoaded('producto')),
            'local' => new LocalResource($this->whenLoaded('local')),
            'stock_actual' => $this->stock_actual,
            'stock_minimo' => $this->stock_minimo,
            'activo' => $this->activo,
            'created_at' => $this->created_at
        ];
    }
}