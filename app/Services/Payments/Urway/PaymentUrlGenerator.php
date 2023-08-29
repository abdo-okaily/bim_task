<?php
namespace App\Services\Payments\Urway;

use App\Models\Transaction;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use URWay\Client as UrwayClient;

class PaymentUrlGenerator extends UrwayClient {
    public function __construct(
        private Transaction $transaction
    ) {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function __invoke() : mixed {
        $this->setTrackId($this->transaction->id)
            ->setCustomerEmail($this->transaction?->customer?->email ?? "{$this->transaction->customer_id}@saudidates.sa")
            ->setCustomerIp(request()->ip())
            ->setCurrency(Constants::currency)
            ->setCountry(Constants::country)
            ->setAmount(number_format($this->transaction->reminder / 100, 2))
            ->setRedirectUrl(route('paymant-callback'))
            ->setAttribute('udf1', $this->transaction->address_id)
            ->setAttribute('udf3', $this->transaction->use_wallet)
            ->setAttribute('udf4', Config::get('app.locale'));

        $this->mergeAttributes(['action' => '1']);
        
        $response = $this->pay();
        
        Log::channel("urway")->info(
            "Urway pay request from ourside",
            ['request_data' => $this->attributes, 'response_data' => (array)$response]
        );
        return $response;
    }
}