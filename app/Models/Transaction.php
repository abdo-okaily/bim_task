<?php

namespace App\Models;

use App\Models\Attributes\TransactionAttributes;
use App\Models\Scopes\CreatedFromScopes;
use App\Models\Scopes\TransactionScopes;
use App\Traits\DbOrderScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model implements HasMedia
{
    use HasFactory, DbOrderScope, InteractsWithMedia, TransactionScopes, CreatedFromScopes, TransactionAttributes;

    Const REGISTERD = 'registered';
    Const SHIPPING_DONE = 'shipping_done';
    Const IN_DELEVERY = 'in_delivery';
    Const COMPLETED = 'completed';
    Const CANCELED = 'canceled';
    Const REFUND = 'refund';

    const MEDIA_COLLECTION_NAME = "customer-invoices";

    protected $fillable=[ 
        'customer_id', 'currency_id', 'date', 'status', 'address_id', 'code', 'products_count',
        'payment_method', 'note', 'coupon_id',
        'total', // is a useless attribute total_amount attribute is the calculated value here
        'sub_total', // product total without vat
        'total_vat', // total vat calculated as amount
        'use_wallet', // is wallet used in this transaction or not
        'wallet_deduction', // the amount used from wallet

         // the reminder amount for customer to pay
         //     (in case there is a wallet deduction this column + wallet_deduction will be the total attribute)
        'reminder',
        'vat_percentage',
        'delivery_fees',
        'discount',
     ];

    public $casts = ["date: datetime"];

    //status => registered,shipping_done,in_delivery,completed,canceled,refund

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function onlinePayment()
    {
        return $this->hasOne(OnlinePayment::class,'transaction_id');
    }
    //addresses

    public function addresses()
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function TransactionLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TransactionLog::class,'transaction_id');
    }    
    
    public function products()
    {
        return $this->hasManyThrough(
            OrderProduct::class,
            Order::class,
            'transaction_id',
            'order_id',
        );
    }

    /**
     * Get the order ship info assossiated to this transaction.
     */
    public function orderShip() : HasOne
    {
        return $this->hasOne(OrderShip::class, 'reference_model_id', 'id');
    }

    public function urwayTransaction() {
        return $this->hasOne(UrwayTransaction::class, 'transaction_id');
    }
}
