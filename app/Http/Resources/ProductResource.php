<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductAttributeResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description,
            'selling_price' => $this->selling_price,
            'special_price' => $this->special_price,
            'status' => $this->status,
            'is_delivery_available' => $this->is_delivery_available,
            'image' => asset("images/$this->image"),
            'attributes' => ProductAttributeResource::collection($this->whenLoaded('attributes')),
        ];
    }
}
