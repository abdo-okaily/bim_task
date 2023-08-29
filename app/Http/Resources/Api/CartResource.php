<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\VendorResource;
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {
        $vatRate = amountInSar($this->totals['vat_rate'] ?? 0);
        $vatPercentage = $this->totals['vat_percentage'] ?? 0;
        $productsTotal = amountInSar($this->totals['total'] ?? 0);
        $deliveryFees = amountInSar($this->totals['delivery_fees'] ?? 0);
        $discount = amountInSar($this->totals['discount'] ?? 0);
        $total = $productsTotal + $vatRate + $deliveryFees - $discount;
        $totalWithoutVat = $productsTotal + $deliveryFees;
        return [
            'id' => $this->id,
            'products_count'      => $this->cart_products_sum_quantity,
            'products_total'      => number_format($productsTotal, 2),
            'delivery_fees'       => number_format($deliveryFees, 2),
            'discount'            => number_format($discount,2),
            'total_without_vat'   => number_format($totalWithoutVat, 2),
            'vat_percentage'      => number_format($vatPercentage, 2),
            'vat_rate'            => number_format($vatRate, 2),
            'total'               => number_format($total, 2),
            'wallet_amount'       => $this->wallet_amount,
            'wallet_amount_label' => number_format($this->wallet_amount, 2),
            'vendors'             => VendorResource::collection($this->vendors),
        ];
    }
}
