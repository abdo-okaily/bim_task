<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductsResource extends JsonResource
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
            'name' => $this->name,
            'desc' => $this->desc,
            'image' => $this->thumb_image,
            'quantity'   => $this->pivot->quantity,
            'price' => $this->price /100,
            'price_before_offer' => $this->price_before_offer /100,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1),
            'is_available' => $this->is_available_product,
        ];
    }
}
