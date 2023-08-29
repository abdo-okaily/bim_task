<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithProductsResource extends JsonResource
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
            'slug' => $this->slug,
            'image' =>'',
            'level' => $this->level,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('d-m-Y'),
            'products' => ProductResource::collection($this->products()->withAvg('reviews','rate')->withSum('orderProducts','quantity')->withCount('reviews')->available()->limit(10)->get()),
            // ->orderBy('created_at','DESC')->limit(20)->get()),
            // 'products' => ProductResource::collection($this->category),
            "product_image" => [
                "full" => $this->image_url,
                "thumb" => $this->image_url_thumb
            ]
        ];
    }
}
