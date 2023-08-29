<?php
namespace App\Services\Payments\Urway;

use App\Models\Transaction;
use Illuminate\Http\Request;

class UrwayServices {
    /**
     * @param Transaction $transaction
     * @return mixed
     */
    public static function generatePaymentUrl(
        Transaction $transaction
    ) : mixed {
        return (new PaymentUrlGenerator($transaction))();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public static function paymentCallback(
        Request $request
    ) : mixed {
        return (new PaymentCallback($request))();
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public static function transactionInquiry(
        Transaction $transaction
    ) : bool {
        return (new PaymentInquiry($transaction))();
    }
}