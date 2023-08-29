<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Exceptions\Integrations\Shipping\CredentialsNotFound;
use App\Exceptions\Integrations\Shipping\AddressComponentNotFound;
use App\Exceptions\Integrations\Shipping\TransactionTotalAmountIsNull;

class DataValidationBeforApiCalls
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";
    
    /**
     * Check data validation before making any API call to torod integration API
     * to avoid any failure thou    ght the shipment operation.
     */
    public function __invoke(Transaction $transaction) : void
    {
        $this->_checkIntegrationCredentialsExists();
        $this->_checkTorodShippingAddressDataExists($transaction);
        $this->_checkTotalTransactionAmountExists($transaction);

    }

    /**
     * Check if torod integration credentials not exists or empty to trhow new exceptions.
     * 
     * @exception CredentialsNotFound
     */
    private function _checkIntegrationCredentialsExists() : void
    {
        if(
            !config("shipping.bezz.acccount_number") || // change url in production to "shipping.torod.production_url"
            !config("shipping.bezz.api_key") ||
            !config("shipping.bezz.base_url")
        ) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:IntegrationCredentialsNotExists", [], true);
            throw new CredentialsNotFound();
        }
    }


    /**
     * Check if transaction address not exists or empty to trhow new exceptions.
     * 
     * @exception AddressComponentNotFound
     */
    private function _checkTorodShippingAddressDataExists(Transaction $transaction) : void
    {
       
        if(
            
            !$transaction->addresses->exists() ||
            !$transaction->addresses->first_name ||
            !$transaction->addresses->last_name ||
            !$transaction->customer->exists() ||
            // (!$transaction->customer->email) ||
            !$transaction->addresses->phone ||
            !$transaction->addresses->city->exists() ||
            !$transaction->addresses->description 
        ) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:_checkShippingAddressDataExists", [
                "is_address_exists" => $transaction->addresses->exists(),
                "first_name" => $transaction->addresses->first_name,
                "last_name" => $transaction->addresses->last_name,
                "is_customer_exists" => $transaction->customer->exists(),
                "customer_email" => $transaction->customer->email ? $transaction->customer->email : $transaction->customer->id . config("shipping.bezz.default_customer_email"),
                "shpping_phone" => $transaction->addresses->phone,
                "shipping_city" => $transaction->addresses->city->exists(),
                "address_description" => $transaction->addresses->description 
            ], true);
            throw new AddressComponentNotFound();
        }
    }


    /**
     * Check if total Transaction amount not exists or empty to trhow new exceptions.
     * 
     * @exception TransactionTotalAmountIsNull
     */
    private function _checkTotalTransactionAmountExists(Transaction $transaction) : void
    {
        if($transaction->total <= 0) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:CheckTotalTransactionAmountExists", ["total_transaction" => $transaction->total], true);
            throw new TransactionTotalAmountIsNull();
        }
    }

   
  


   
}