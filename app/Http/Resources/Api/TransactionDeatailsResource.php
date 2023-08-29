<?php

namespace App\Http\Resources\Api;

use App\Enums\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDeatailsResource extends JsonResource
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
            'shipment_fee' => $this->delivery_fees_in_sar_rounded,
            'discount' => $this->discount_in_sar_rounded,
            'products_total' => $this->sub_total_in_sar_rounded,
            'products_total_with_vat' => $this->sub_total_with_vat_in_sar_rounded,
            'products_and_devliery_without_vat' => $this->sub_total_and_delivery_fees_sar_rounded,
            'total' => $this->total_amount_rounded ,  // sub discounta
            'wallet_detaction' => $this->wallet_deduction_in_sar_rounded,
            'total_without_vat' => $this->total_without_vat_in_sar_rounded,
            'vat_percentage' => $this->vat_percentage ? $this->vat_percentage : 0,
            'vat_rate' => $this->vat_rate_rounded ? $this->vat_rate_rounded : 0,
            'products_count' => $this->products_count,
            'inv_url' => $this->inv_url,
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'payment_method' => PaymentMethods::getStatusList()[$this->payment_method] ?? "",
            'status' => $this->status,
            'orders' => OrderResource::collection($this->orders),
        ];
    }
}
