<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InventoryResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'sku' => $this->sku,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio_venta' => $this->precio_venta,
            'precio_compra' => $this->precio_compra,
            'categoria' => new CategoryResource($this->whenLoaded('categoria')),
            'inventarios' => InventoryResource::collection($this->whenLoaded('inventarios')),
            'stock_total' => $this->inventarios->sum('stock_actual'),
            'activo' => $this->activo,
            'created_at' => $this->created_at
        ];
    }
}