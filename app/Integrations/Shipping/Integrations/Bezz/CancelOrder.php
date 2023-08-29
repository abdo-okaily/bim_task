<?php

namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class CancelOrder
{
    use Logger;

    /**
     * Api Endpoint to get order_id.
     */
    const ENDPOINT = "Orders/CancelOrder";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";
    
    /**
     * Get shipment order_id.
     */
    public function __invoke(Transaction $transaction) : array
    {
        $this->logger(self::LOG_CHANNEL, "BEZZ:START_CancelOrder", [], false);
        
        $data = [
         'OrderNumber'=>717,
         'AccountNumber'=>config("shipping.bezz.acccount_number"),
         'ApiKey'=> config("shipping.bezz.api_key"),    
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->timeout(60)->post(config("shipping.bezz.base_url").self::ENDPOINT,$data);


    
        if($response->status() == 201 ||$response->status() == 200 ){
            $message=[
                'message'=>'order cancel successfully',
            ];
        }elseif($response->status() == 403){
            $message=[
                'message'=>'order already been cancelled ',
            ];
        }else{
            $message=[
                'message'=>'order not found to cancel '
            ];
        }

        $this->logger(self::LOG_CHANNEL, "BEZZ: " .$message['message'] , $message, $response->failed());
        
        return [
            'code'=>$response->status(),
            "message" => $message['message'],
            "data" => $data
        ];
    }
}