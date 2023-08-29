<?php

namespace App\Http\Resources\Api;
use App\Http\Resources\Api\OrderProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'code' => $this->code,
            'status' => $this->transaction->status ?? $this->status,
            'products' => OrderProductResource::collection($this->products),

        ];
    }
}
