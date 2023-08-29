<?php
namespace App\Traits;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;

trait OrderModelScope {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $transactionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTransaction(Builder $query, int $transactionId) : Builder {
        return $query->where('transaction_id', $transactionId);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrackable(Builder $query) : Builder {
        return $query->where(
            fn($q) => $q->where('status', '!=', OrderStatus::COMPLETED)
                ->where('status', '!=', OrderStatus::CANCELED)
                ->where('status', '!=', OrderStatus::SHIPPING_DONE)
        );
    }
}