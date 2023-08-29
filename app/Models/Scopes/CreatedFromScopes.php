<?php
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CreatedFromScopes {
    public function scopeCreatedTenMinutesAgo(Builder $query) : Builder {
        return $query->where("created_at", "<=", now()->subMinutes(10)->format("Y-m-d H:i:s"));
    }
}