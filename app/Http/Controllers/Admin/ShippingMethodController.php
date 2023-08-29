<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DomesticZone as EnumsDomesticZone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Delivery\CreateShippingMethodRequest;
use App\Http\Requests\Admin\Delivery\UpdateShippingMethodRequest;
use App\Enums\ShippingMethodKeys;
use App\Enums\ShippingMethodType;
use App\Http\Requests\Admin\Delivery\ShippingMethodSyncZonesRequest;
use App\Models\DomesticZone;
use App\Models\ShippingMethod;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\Admin\ShippingMethodRepository;

class ShippingMethodController extends Controller
{
    private string $view;
    public function __construct(public ShippingMethodRepository $shippingMethodRepository)
    {
        $this->view = 'admin/shipping_methods/';
    }
    public function index(Request $request)
    {
        return view($this->view .'index', [
            'shippingMethods' => $this->shippingMethodRepository->getPaginated($request),
        ]);
    }

    public function create()
    {
        return view( $this->view .'create', [
            'integrationKeys' => ShippingMethodKeys::getKeys(),
            'shipping_types' => ShippingMethodType::getTypesList(),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
        ]);
    }

    public function store(CreateShippingMethodRequest $request)
    {
        $data = $request->all();
        $data['name'] = ['en' => $request->name_en, 'ar' => $request->name_ar];
        
        $id = ShippingMethod::create($data)->id;
        
        Alert::success('success', __('admin.shippingMethods.messages.created_successfully_title'));
        return redirect()->route("admin.shipping-methods.show", ['shipping_method' => $id]);
    }

    public function show($id)
    {
        $shippingMethod = $this->shippingMethodRepository->getModelUsingID($id);
        return view($this->view .'show', [
            'shippingMethod' => $shippingMethod->load('domesticZones'),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
            'domesticZones' => DomesticZone::when(
                    $shippingMethod->type == EnumsDomesticZone::INTERNATIONAL_TYPE,
                    fn($q) => $q->international()
                )
                ->when(
                    $shippingMethod->type == EnumsDomesticZone::NATIONAL_TYPE,
                    fn($q) => $q->national()
                )
                ->where(function ($q) use ($id) {
                    $q->whereDoesnthave('shippingMethods')
                    ->orWhereHas('shippingMethods', fn($_q) => $_q->where('shipping_method_id', $id));
                })
                ->select('id', 'name')->get()
        ]);
    }

    public function edit($id)
    {
        return view($this->view .'edit', [
            'shippingMethod' => $this->shippingMethodRepository->getModelUsingID($id),
            'integrationKeys' => ShippingMethodKeys::getKeys(),
            'shipping_types' => ShippingMethodType::getTypesList(),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
        ]);
    }

    public function update(UpdateShippingMethodRequest $request, $id)
    {
        $this->shippingMethodRepository->updateShippingMethod($request, $id);
        Alert::success('success', __('admin.shippingMethods.messages.updated_successfully_title'));
        return redirect()->route("admin.shipping-methods.show", ['shipping_method' => $id]);
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return redirect()->route('admin.shipping-methods.index');
    }

    public function syncZones(ShippingMethodSyncZonesRequest $request, ShippingMethod $shippingMethod) {
        $shippingMethod->domesticZones()->sync($request->get('domesticZones') ?? []);
        Alert::success('success', __('admin.shippingMethods.messages.related-domestic-zones-synced'));
        return back();
    }
}
