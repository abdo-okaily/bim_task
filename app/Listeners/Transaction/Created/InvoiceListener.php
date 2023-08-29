<?php

namespace App\Listeners\Transaction\Created;

use Error;
use Exception;
use App\Models\Setting;
use App\Events\Transaction;
use App\Models\Transaction as TransactionModel;
use Illuminate\Support\Facades\Log;

class InvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Transaction\Created $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $transaction = $event->getTransaction();
            $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key")->toArray();
            $transaction = $transaction->load([
                "orders.orderProducts.product",
            ]);
    
            $pdf = \PDF::loadView('admin.transaction.invoice_pdf', compact("settings", "transaction"));
    
            $fileName = "order_invoice_" . $transaction->id . "_" . time() . ".pdf";
            $path = "pdf_temp/" . $fileName;
            $fullPath = public_path($path);
            $pdf->save($fullPath);
            $transaction->addMedia($fullPath)
                ->usingName($fileName)
                ->setFileName($fileName)
                ->toMediaCollection(TransactionModel::MEDIA_COLLECTION_NAME);
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in InvoiceListener: ". $e->getMessage());
        }
    }

    /**
     * Array of invoice header info.
     */
    private function _invoiceHeaderInfo() : array
    {
        return [
            "site_logo",
            "address",
            "zip_code",
            "legal_registration_no",
            "email",
            "website",
            "phone",
            "tax_no"
        ];
    }
}
