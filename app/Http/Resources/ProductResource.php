<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'image' => $this->thumbnail,
            'gallery' => $this->gallery,
            'weight' => $this->unit,
            'price' => $this->price / 100,
            'origin_price' => $this->original_price / 100,
            'category' => new CategoryResource($this->category),
        ];
    }
}
