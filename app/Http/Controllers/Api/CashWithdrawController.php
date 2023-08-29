<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CashWithdrawRequest;
use App\Models\CustomerCashWithdrawRequest;
use Illuminate\Http\Response;

class CashWithdrawController extends ApiController
{
    public function store(CashWithdrawRequest $request)
    {
        $customer = auth('api')->user();

        if ($customer->ownWallet) {
            // Check available balance, if not enough refuse request
            if (($customer->ownWallet->amount_with_sar ?? 0) < $request->amount) {
                return $this->setApiResponse(
                    false,
                    Response::HTTP_BAD_REQUEST,
                    [],
                    __('cashWithdrawRequest.messages.not-enough-balance')
                );
            }

            // Otherwise create
            CustomerCashWithdrawRequest::create([
                'customer_id' => $customer->id,
                'bank_id' => $request->get('bank_id'),
                'amount' => $request->get('amount'),
                'bank_account_name' => $request->get('bank_account_name'),
                'bank_account_iban' => $request->get('bank_account_iban'),
            ]);
        }

        return $this->setApiResponse(
            true,
            Response::HTTP_OK,
            [],
            __('cashWithdrawRequest.messages.request-sent-to-admin')
        );
    }
}
