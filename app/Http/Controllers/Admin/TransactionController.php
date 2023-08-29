<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Models\Setting;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\Admin\TransactionService;
use App\Repositories\Api\TransactionRepository;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public $service;
    public $repository;

    public function __construct(TransactionService $service, TransactionRepository $repository) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        $query = Transaction::select('transactions.*','users.name')
            ->join('users', 'transactions.customer_id', '=', 'users.id');
        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Admin\Transaction\FilterStatus::class,
                \App\Pipelines\Admin\Transaction\FilterCustomer::class,
                \App\Pipelines\Admin\Transaction\FilterCode::class,
                \App\Pipelines\Admin\Transaction\FilterDate::class
            ])
            ->thenReturn();
        $transactions = $query->descOrder()->paginate(10)->withQueryString();

        return view('admin.transaction.index',['transactions' => $transactions]);
    }

    /**
     * Get Cart using id.
     *
     * @param id $cart_id
     * @return Response
     */
    public function show(int $transactionId) {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        return view('admin.transaction.show',[
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index')
        ]);
    }

    public function manage(int $transactionId) {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        return view('admin.transaction.manage',[
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index'),
            'statuses' => OrderStatus::getStatusList(),
        ]);
    }

    public function update(Transaction $transaction) {
        if (!OrderStatus::isStatusHasHigherOrder($transaction->status, request()->get('status'))) {
            return redirect()->back()->with("error", __('admin.transaction_status_not_high'));
        }
        if (
            (request()->get('status') == OrderStatus::IN_DELEVERY || request()->get('status') == OrderStatus::SHIPPING_DONE) &&
            (!$transaction->orderShip || !$transaction->orderShip->gateway_tracking_id)
        ) return redirect()->back()->with("error", __('admin.transaction_not_has_ship'));
        // TODO: refactor (update orders status after update transaction status)
            // $transaction = $this->service->update($transaction);
        if (request()->get('status') != $transaction->status) {
            $transaction->update([
                'status' => request()->get('status'),
                'note' => request()->get('note'),
            ]);
            switch(request()->get('status')) {
                case OrderStatus::CANCELED:
                    event(new TransactionEvents\Cancelled($transaction->load("orders.vendor.wallet.transactions")));
                    break;
                case OrderStatus::IN_DELEVERY:
                    event(new TransactionEvents\OnDelivery($transaction));
                    break;
                case OrderStatus::SHIPPING_DONE:
                    event(new TransactionEvents\Delivered($transaction->load("orders.vendor.wallet.transactions")));
                    break;
                case OrderStatus::COMPLETED:
                    event(
                        new TransactionEvents\Completed($transaction->load("orders.vendor.wallet.transactions"))
                    );
                    break;
            }
        } else {
            $transaction->update(['note' => request()->get('note')]);
        }

        return redirect()->route('admin.transactions.manage', ['transaction' => $transaction]);
    }

    /**
     * Return Invoice Page.
     */
    public function invoice(int $transactionId) : View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key");
        $transaction = $transaction->load([
            "orders.orderProducts.product",
        ]);
        return view('admin.transaction.invoice',[
            'transaction' => $transaction,
            'settings' => $settings,
            'breadcrumbParent' => 'admin.transactions.show',
            'breadcrumbParentUrl' => route('admin.transactions.show', $transactionId)
        ]);
    }

    /**
     * Return Invoice Page.
     */
    public function invoicePdf(int $transactionId) : View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key")->toArray();
        $transaction = $transaction->load([
            "orders.orderProducts.product",
        ]);

        $pdf = \PDF::loadView('admin.transaction.invoice_pdf', compact("settings", "transaction"), [],  [  
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        return $pdf->stream('order_invoice.pdf');
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
