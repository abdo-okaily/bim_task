<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Repositories\Admin\WarehouseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WarehouseService
{
    /**
     * Warehouse Service Constructor.
     *
     * @param WarehouseRepository $repository
     */
    public function __construct(public WarehouseRepository $repository) {}

    /**
     * Get Warehouse.
     *
     * @return Collection
     */
    public function getAllWarehouse() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Warehouse with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllWarehousesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $warehouses = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $warehouses->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }else{
                $warehouses = $warehouses->where('name->ar', 'LIKE', "%{$request->search}%")
                ->orwhere('name->en', 'LIKE', "%{$request->search}%");

            }
        }

        return $warehouses->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Warehouse using ID.
     *
     * @param integer $id
     * @return Warehouse
     */
    public function getWarehouseUsingID(int $id) : Warehouse
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Warehouse.
     *
     * @param Request $request
     * @return array
     */
    public function createWarehouse(Request $request) : array
    {       
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ]
        ]);

        $warehouse = $this->repository->store(
            $request->except('_method', '_token')
        );
        $warehouse->countries()->attach($request['countries']);

        if(!empty($warehouse)) {
            return [
                "success" => true,
                "title" => trans("admin.warehouses.messages.created_successfully_title"),
                "body" => trans("admin.warehouses.messages.created_successfully_body"),
                "id" => $warehouse->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.warehouses.messages.created_error_title"),
            "body" => trans("admin.warehouses.messages.created_error_body"),
        ];
    }

    /**
     * Update Warehouse Using ID.
     *
     * @param integer $warehouse_id
     * @param Request $request
     * @return array
     */
    public function updateWarehouse(int $warehouse_id, Request $request) : array
    {
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ]
        ]);

        $warehouse = $this->getWarehouseUsingID($warehouse_id);

        $this->repository->update($request->except('_method', '_token'), $warehouse);
        $warehouse->countries()->sync($request['countries']);

        return [
            "success" => true,
            "title" => trans("admin.warehouses.messages.updated_successfully_title"),
            "body" => trans("admin.warehouses.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Warehouse Using.
     *
     * @param int $warehouse_id
     * @return array
     */
    public function deleteWarehouse(int $warehouse_id) : array
    {
        $warehouse = $this->getWarehouseUsingID($warehouse_id);
        $isDeleted = $this->repository->delete($warehouse);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.warehouses.messages.deleted_successfully_title"),
                "body" => trans("admin.warehouses.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.warehouses.messages.deleted_error_title"),
            "body" => trans("admin.warehouses.messages.deleted_error_message"),
        ];
    }
}
