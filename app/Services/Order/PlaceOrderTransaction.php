<?php
namespace App\Services\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\WalletTransactionTypes;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Exceptions\Wallet\NotEnoughBalance;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Order\Contracts\PlaceOrderDataInterface;
use App\Services\Order\Contracts\PlaceOrderResponseInterface;
use App\Services\Order\Contracts\PlaceOrderTransactionInterface;
use App\Services\Wallet\CustomerWalletService;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class PlaceOrderTransaction implements PlaceOrderTransactionInterface {
    private PlaceOrderDataInterface $placeOrderData;
    private bool $usingWallet = false;
    private float $reminderAmount;
    private float $walletDeductedAmount = 0;
    private int $paymentMethod;

    public function __construct(PlaceOrderDataInterface $placeOrderData) {
        $this->placeOrderData = $placeOrderData;
    }

    /**
     * @param bool $usingWallet
     * @return PlaceOrderTransactionInterface
     */
    public function setUsingWallet(bool $usingWallet) : PlaceOrderTransactionInterface {
        $this->usingWallet = $usingWallet;
        return $this;
    }

    /**
     * @param int $paymentMethod
     * @return PlaceOrderTransactionInterface
     */
    public function setPaymentMethod(int $paymentMethod) : PlaceOrderTransactionInterface {
        // TODO: wehn add a new payment method we must hanlde this block
        $paymentMethod = in_array($paymentMethod, [PaymentMethods::VISA, PaymentMethods::CASH, PaymentMethods::WALLET]) ? $paymentMethod : PaymentMethods::CASH;
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return PlaceOrderResponseInterface
     * @throws Exception|Error
     */
    public function saveTransaction() : PlaceOrderResponseInterface {
        if (!isset($this->paymentMethod)) throw new Exception("Please set a valid payment method");
        
        try {
            DB::beginTransaction();
            $cartTotalAmount = $this->placeOrderData->getTotalAmount();
            $this->reminderAmount = $cartTotalAmount;
            $wallet = Wallet::where("customer_id", $this->placeOrderData->getCustomer()->id)->first();
            if ($wallet) {
                if ($this->paymentMethod == PaymentMethods::WALLET) {
                    $this->isWalletValid($wallet, $cartTotalAmount);
                }
                $this->deductWalletAmount($wallet, $cartTotalAmount);
            }
            
            if ($this->usingWallet && $this->reminderAmount <= 0) {
                $this->paymentMethod = PaymentMethods::WALLET;
            }
            $transaction = $this->createTransaction();
            
            if (!$transaction) throw new PlaceOrderBusinessException("Transaction not created");
            
            $this->placeOrderData->getCart()->vendors->each(function ($vendor) use ($transaction) {
                $order = $this->createOrder($transaction, $vendor->totals, $vendor->id);
            
                if (!$order) throw new PlaceOrderBusinessException("Order not created");
            
                $vendor->cartProducts->each(function ($product) use (&$order, $vendor) {
                    $total = $product->price * $product->pivot->quantity;
                    $order->products()->attach($product->id, [
                        'total'          => $total,
                        'quantity'       => $product->pivot->quantity,
                        'unit_price'     => $product->price,
                        'vat_percentage' => $vendor->totals['vat_percentage'],
                        'discount'       => 0,// TODO: copoun must be divided by percentage for all products
                    ]);
                });
            });
            DB::commit();
            return PlaceOrder::getPaymentResponse($transaction, $this->paymentMethod);
        } catch (Exception | Error $e) {
            DB::rollBack();
            $this->rollbackWalletDeductedAmount();
            throw $e;
        }
    }

    /**
     * @return Transaction
     */
    private function createTransaction() : Transaction {
        $customer = $this->placeOrderData->getCustomer();
        $cartTotals = $this->placeOrderData->getCart()->totals;

        $coupon = $this->placeOrderData?->getCoupon();

        if ($coupon) {
            $coupon->increment('number_of_redemptions', 1);
            $coupon->couponUsers()->attach($customer->id);
        }
        
        return Transaction::create([
            'customer_id'      => $this->placeOrderData->getCustomer()->id,
            'currency_id'      => $customer->currency_id,
            'date'             => Carbon::now(),
            'status'           => $this->paymentMethod == PaymentMethods::WALLET || $this->reminderAmount == 0 ? OrderStatus::PAID : OrderStatus::REGISTERD,
            'sub_total'        => $cartTotals['sub_total'],
            'total'            => $cartTotals['total'],
            'total_vat'        => $cartTotals['total_vat'],
            'total_tax'        => 0,
            'vat_percentage'   => $cartTotals['vat_percentage'],
            'delivery_fees'    => $cartTotals['delivery_fees'],
            'discount'         => $cartTotals['discount'],
            'address_id'       => $this->placeOrderData->getAddress()->id,
            'use_wallet'       => $this->usingWallet,
            'wallet_deduction' => $this->walletDeductedAmount,
            'reminder'         => $this->reminderAmount,
            'payment_method'   => $this->paymentMethod,
            'products_count'   => $this->placeOrderData->getProductsCount(),
            'code'             => transactionCode(),
            'coupon_id'        => $coupon?->id
        ]);
    }

    /**
     * @param Transaction $transaction
     * @param array $totals
     * @param int $vendorId
     * @return Order
     */
    private function createOrder(Transaction $transaction, array $totals, int $vendorId) : Order {
        return Order::create([
            'transaction_id'     => $transaction->id,
            'vendor_id'          => $vendorId,
            'date'               => Carbon::now(),
            'status'             => OrderStatus::REGISTERD,
            'delivery_type'      => 'aramex',
            'vat'                => $totals['vat_rate'],
            'sub_total'          => $totals['sub_total'],
            'total'              => $totals['total'],
            'tax'                => 0,
            'vat_percentage'     => $totals['vat_percentage'],
            'delivery_fees'      => $totals['delivery_fees'],
            'discount'           => $totals['discount'],
            'company_percentage' => $totals['company_percentage'],
            'company_profit'     => $totals['company_profit'],
            'vendor_amount'      => $totals['vendor_amount'],
            'code'               => orderCode(),
        ]);
    }

    /**
     * @param Wallet $wallet
     * @param float $totalAmount
     * @return bool
     */
    private function isWalletValid(Wallet $wallet, float $totalAmount) : bool {
        if ($wallet->amount < $totalAmount) throw new NotEnoughBalance;
        return true;
    }
    /**
     * @param Wallet $wallet
     * @param float $totalAmount
     * @throws NotEnoughBalance
     */
    private function deductWalletAmount(Wallet $wallet, float $totalAmount) {
        $customer = $this->placeOrderData->getCustomer();
        $this->reminderAmount = $cartTotalAmount = $totalAmount;
        
        if ($this->usingWallet && $wallet && $wallet->amount > 0) {
            if ($wallet->amount >= $cartTotalAmount) {
                $this->walletDeductedAmount = $cartTotalAmount;
                $this->reminderAmount = 0;
            } else {
                $this->walletDeductedAmount = $wallet->amount;
                $this->reminderAmount = $cartTotalAmount - $wallet->amount;
            }
            try {
                CustomerWalletService::withdraw(
                    $customer,
                    $this->walletDeductedAmount / 100,
                    WalletTransactionTypes::PURCHASE
                );
            } catch (NotEnoughBalance $e) {
                throw $e;
            } catch (Exception $e) {
                $this->walletDeductedAmount = 0;
                $this->reminderAmount = $cartTotalAmount;
                $this->usingWallet = false;
            }
        }
    }

    private function rollbackWalletDeductedAmount() {
        $customer = $this->placeOrderData->getCustomer();
        if (!$customer->ownWallet || $this->walletDeductedAmount <= 0) return;
        
        CustomerWalletService::deposit(
            $customer,
            $this->walletDeductedAmount,
            WalletTransactionTypes::COMPENSATION
        );
    }
}