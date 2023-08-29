<?php

namespace App\Services\Api;

use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use App\Repositories\Api\CountryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CountryService
{
    /**
     * Country Service Constructor.
     *
     * @param CountryRepository $repository
     */
    public function __construct(public CountryRepository $repository) {}

    /**
     * Get Countries.
     *
     * @return Collection
     */
    public function getAllCountries() : array
    {
        //
        $countries = $this->repository->all()->active()->get();
        return [        'success'=>true,
                        'status'=>200 ,
                        'data'=> CountryResource::Collection($countries),
                        'message'=>__('api.countries.retrived')
            ];
    }

    /**
     * Get Countries with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCountriesWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get Country using ID.
     *
     * @param integer $id
     * @return Country
     */
    public function getCountryUsingID(int $id) : Country|null
    {
        return $this->repository->getModelUsingID($id);
    }

}