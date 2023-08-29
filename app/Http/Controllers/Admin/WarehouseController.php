<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WarehouseIntegrationKeys;
use Illuminate\Http\Request;
use App\Services\Admin\WarehouseService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\CreateWarehouseRequest;
use App\Http\Requests\Admin\UpdateWarehouseRequest;
use App\Models\Country;

class WarehouseController extends Controller
{
    /**
     * Warehouse Controller Constructor.
     *
     * @param WarehouseService $service
     */
    public function __construct(public WarehouseService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $warehouses = $this->service->getAllWarehousesWithPagination($request);

        return view("admin.warehouses.index", compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $countries = Country::active()->whereDoesntHave('warehouseCountry')->select("name", "id")->get();
        if($countries->isEmpty()) return redirect(route('admin.warehouses.index'))->with("error", __("admin.warehouses.empty-countries"));
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');
        $integrationKeys = WarehouseIntegrationKeys::getKeys();

        return view(
            "admin.warehouses.create",
            compact("breadcrumbParent", "breadcrumbParentUrl", "integrationKeys", "countries")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWarehouseRequest  $request
     * @return Redirect
     */
    public function store(CreateWarehouseRequest $request)
    {
        $result = $this->service->createWarehouse($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.warehouses.show", $result["id"]);
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
        $warehouse = $this->service->getWarehouseUsingID($id);
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');

        return view("admin.warehouses.show", compact('warehouse', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $countries = Country::active()
            ->where(
                function($q) use ($id) {
                    $q->whereDoesntHave('warehouseCountry');
                    $q->orWhereHas('warehouseCountry', fn($_q) => $_q->where('warehouse_id', $id));
                }
            )
            ->select("name", "id")->get();
        $warehouse = $this->service->getWarehouseUsingID($id)->load('countries');
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');
        $integrationKeys = WarehouseIntegrationKeys::getKeys();

        return view("admin.warehouses.edit", compact(
            "warehouse",
            "breadcrumbParent",
            "breadcrumbParentUrl",
            "integrationKeys",
            "countries"
        ));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateWarehouseRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateWarehouseRequest $request, int $id)
    {
        $result = $this->service->updateWarehouse($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.warehouses.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Warehouse Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteWarehouse($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.warehouses.index');
    }
}