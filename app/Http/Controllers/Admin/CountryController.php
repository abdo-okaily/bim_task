<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CountryStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\CountryService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\CountryResource;
use App\Http\Requests\Admin\CreateCountryRequest;
use App\Http\Requests\Admin\UpdateCountryRequest;

class CountryController extends Controller
{
    /**
     * Product Class Controller Constructor.
     *
     * @param CountryService $service
     */
    public function __construct(public CountryService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $countries = $this->service->getAllCountriesWithPagination($request);

        return view("admin.countries.index", compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $stateOfCountry = CountryStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.countries.index';
        $breadcrumbParentUrl = route('admin.countries.index');

        return view("admin.countries.create", compact("stateOfCountry", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCountryRequest  $request
     * @return Redirect
     */
    public function store(CreateCountryRequest $request)
    {
        $result = $this->service->createCountry($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.countries.show", $result["id"]);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $country = $this->service->getCountryUsingID($id);
        $breadcrumbParent = 'admin.countries.index';
        $breadcrumbParentUrl = route('admin.countries.index');

        return view("admin.countries.show", compact('country', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $country = $this->service->getCountryUsingID($id);
        $stateOfCountry = CountryStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.countries.index';
        $breadcrumbParentUrl = route('admin.countries.index');

        return view("admin.countries.edit", compact('country', 'stateOfCountry', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateCountryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateCountryRequest $request, int $id)
    {
        $result = $this->service->updateCountry($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.countries.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Product Class Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        abort(403);
        // $result = $this->service->deleteCountry($id);

        // if($result["success"] == true) {
        //     Alert::success($result["title"], $result["body"]);
        // } else {
        //     Alert::error($result["title"], $result["body"]);
        // }

        // return redirect()->route('admin.countries.index');
    }
}