<?php
namespace App\Http\Controllers\Admin;
use App\Events\Admin\Product\Approve;
use App\Events\Admin\Product\Modify;
use App\Events\Admin\Product\Reject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductQuantity;
use App\Models\ProductTemp;
use App\Models\Vendor;
use App\Repositories\Admin\ProductRepository as ProductRepository;
use App\Services\Images\ProductImageService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    private $productRepository;
    private $productImageService;

    public function __construct(ProductRepository $productRepository, ProductImageService $productImageService) {
        $this->productRepository = $productRepository;
        $this->productImageService = $productImageService;
    }

    public function index()
    {
        try {
            return view(
                "admin.products.index",
                ['products' => $this->productRepository->getProductsPaginated(request())]
            );
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function create()
    {

        try {
            $breadcrumbParent = 'admin.products.index';
            $breadcrumbParentUrl = route('admin.products.index');
            $main_categories = $this->getMainCategoriesForSelect();
            $sub_categories = old('category_id') ? $this->getSubCategoriesForSelect(old('category_id')) : [];
            $final_categories = old('sub_category_id') ? $this->getSubCategoriesForSelect(old('sub_category_id')) : [];
            $quantity_types = ProductQuantity::getProductQuantityTypes();
            $types = ProductClass::getProductClasses();
            $vendors = Vendor::pluck('name', 'id')->toArray();
            return view("admin.products.create", compact('main_categories', 'sub_categories', 'final_categories', 'quantity_types', 'types', 'vendors', "breadcrumbParent", "breadcrumbParentUrl"));
        } catch (Exception $e) {
            Alert::error('', $e->getMessage());
            return redirect()->back();
            return redirect()->route('admin.home');
        }
    }


    public function store(CreateProductRequest $request)
    {
        try {
            $request->merge(['is_active' => 1]);
            $request->merge(['desc' => ['ar' => $request->desc_ar, 'en' => $request->desc_en]]);
            $data = $request->all();
            unset($data['desc_ar']);
            unset($data['desc_en']);
            $product = $this->productRepository->store_product($data);
            if ($product) $this->productImageService->handleImages($product);
            return redirect(route('admin.products.index'))
                ->with(['success' => trans('admin.products.messages.created_successfully_title')]);
        } catch (Exception $e) {
            Alert::error('System Error', $e->getMessage());
            return redirect()->back();
            // return redirect()->route('admin.home');
        }
    }

    public function show($product_id)
    {
        try {
            $data['row'] = $this->productRepository->show(
                $product_id,
                ['images', 'vendor.owner', 'reviews', 'quantity_type', 'type', 'category', 'subCategory', 'finalSubCategory','temp']
            );
            
            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.products.index';
                $data['breadcrumbParentUrl'] = route('admin.products.index');
                return view("admin.products.show", $data);
            }

        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function edit($id)
    {
        try {
            $data['row'] = $this->productRepository->show($id);
            $data['main_categories'] = $this->getMainCategoriesForSelect();
            $data['sub_categories'] = $this->getSubCategoriesForSelect($data['row']->category_id);
            $data['final_categories'] = $this->getSubCategoriesForSelect($data['row']->sub_category_id);
            $data['quantity_types'] = ProductQuantity::getProductQuantityTypes();
            $data['types'] = ProductClass::getProductClasses();
            $data['vendors'] = Vendor::pluck('name', 'id')->toArray();
            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.products.index';
                $data['breadcrumbParentUrl'] = route('admin.products.index');
                return view("admin.products.edit", $data);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $request->merge(['desc' => ['ar' => $request->desc_ar, 'en' => $request->desc_en]]);
            $data = $request->all();
            unset($data['desc_ar']);
            unset($data['desc_en']);
            $product = $this->productRepository->update_product($data, $id);
            if ($product) {
                $this->productImageService->handleImages($product);
                event(new Modify($product));
                return redirect()->route('admin.products.index')->with(['success' => trans('admin.products.messages.updated_successfully_title')]);
            }

        } catch (Exception $e) {
            Alert::error('', $e->getMessage());
            return redirect()->back();
            return redirect()->route('admin.home');
        }
    }


    public function destroy($id)
    {
        if (!$product_check = $this->productRepository->show($id))
            return redirect()->route('admin.products.index');

        try {
            $product = $this->productRepository->destroy_product($id);
            return redirect()->route('admin.products.index')->with(['success' => trans('admin.products.messages.deleted_successfully_title')]);
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function getSubCategories(Request $request)
    {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($request->parent_id));
    }

    public function acceptProduct(Product $product) {

        if ($product->status != 'accepted'){
            $product->update(['status' => 'accepted', 'is_active' => 1]);
            event(new Approve($product));
        }else if ($product->status != 'pending'){
            $product->update(['status' => 'pending', 'is_active' => 0]);
            event(new Reject($product));
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function acceptUpdate(Product $product)
    {
        if($product->temp){
            $this->productRepository->updateProductAfterAccept($product);
            $this->productImageService->handleImages($product);
            $product->temp()->delete();
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function approve(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->status = 'accepted';
        $product->save();
        event(new Approve($product));
        return response()->json(['status' => 'success','data' => $product->status,'message' => __('admin.products.messages.status_approved_successfully_title')],200);
    }

    public function refuseUpdate(Product $product)
    {
        if($product->temp){
            $product->temp()->update(['approval'=>ProductTemp::REFUSED,'note'=>request()->note]);
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function printBarcode(Product $product) {
        return view("admin.products.print-barcode", ['product' => $product]);
    }

    private function activeCategories($parentId = null) {
        return Category::active()
            ->when($parentId ,fn($q) => $q->where('parent_id', $parentId))
            ->when(!$parentId ,fn($q) => $q->whereNull('parent_id'))
            ->select('name','id')->get();
    }

    private function getMainCategoriesForSelect() : array {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories());
    }

    private function getSubCategoriesForSelect($parentId) : array {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($parentId));
    }

    private function addSelectOptionToCategoriesOptins(Collection $categories) : array {
        $option = new Category([
            'name' => [
                "ar" => __('admin.select-option', [], 'ar'),
                "en" => __('admin.select-option', [], 'ar')
            ]
        ]);
        $categories->prepend($option);
        return $categories->pluck('name', 'id')->toArray();
    }


}
