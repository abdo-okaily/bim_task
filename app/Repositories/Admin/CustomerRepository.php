<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class CustomerRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return User::class;
    }

    /**
     * Get list of customer form users table where type of user is equle to customer.
     * This method used for select menu.
     *
     * @return array
     */
    public function getCustomersList() : array
    {
        return $this->all()
                    ->where("type", "customer")
                    ->select("id", "name")
                    ->get()
                    ->toArray();
    }
}
