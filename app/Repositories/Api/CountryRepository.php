<?php

namespace App\Repositories\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class CountryRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Country::class;
    }
}