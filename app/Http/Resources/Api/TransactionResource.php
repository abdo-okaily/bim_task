<?php

namespace App\Http\Resources\Api;

use App\Enums\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => $this->total_amount_rounded,
            'inv_number' => $this->code,
            'inv_url' => $this->inv_url,
            'payment_method' => PaymentMethods::getStatus($this->payment_method),
            'status' => $this->status,
            'date' => Carbon::parse($this->date)->format('Y/m/d') ,
            'status_text' => __('api.custom-transaction-status.'. $this->status),

        ];
    }
}
