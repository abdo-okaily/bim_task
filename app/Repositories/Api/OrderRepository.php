<?php

namespace App\Repositories\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class OrderRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Order::class;
    }

}
