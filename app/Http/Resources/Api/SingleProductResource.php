<?php

namespace App\Http\Resources\Api;

use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = ProductImageResource::collection($this->images);
        $images = $images->toArray($this->images);
        array_unshift( $images ,[
            'id' => $this->id,
            'product_id' => $this->id,
            'url' => $this->square_image
        ]);

        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'image' => $this->square_image,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'total_weight' => $this->total_weight,
            'net_weight' => $this->net_weight,
            'barcode' => $this->barcode,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'price' => $this->price_in_sar_rounded,
            'price_before_offer' => $this->price_before_offer /100,
            'order' => $this->order,
            'expire_date' => $this->expire_date,
            'quantity_bill_count' => $this->quantity_bill_count,
            'bill_weight' => $this->bill_weight,
            'category_id' => $this->category_id,
            'quantity_type_id' => $this->quantity_type_id,
            'type_id' => $this->type_id,
            'is_visible' => $this->is_visible,
            'vendor_id' => $this->vendor_id,
            'vendor' => $this->vendor->name ?? '',
            'certificates'=> CertificateResource::collection($this->vendor->approved_certificates   ),
            'created_at' => $this->created_at->format("d-m-Y"),
            'product_class_id' =>  $this->type_id,
            'rate' => [
                'value'=> (float)number_format($this->rate, 1)?? 0,
                ],
            'reviews_count' =>$this->reviews_conunt ?? 0 ,
            'category' => ($this->category) ? $this->category->name : null,
            'type' => ($this->type) ? $this->type->name : null,
            'quantity_type' => ($this->quantity_type) ? $this->quantity_type->name : null,
            'images' => $images,
            'reviews' => ProductReviewResource::collection($this->approvedReviews),
            'is_favorite' => auth('api')->user() ?
                ( auth('api')->user()->favorite_products->contains($this->id)? 1 : 0 )
                : 0,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1),
            'product_classes'=> ProductClassRepsource::collection($this->product_classes),
            'total_weight_label' => $this->total_weight_label,
            'net_weight_label' => $this->net_weight_label,
        ];
    }
}
