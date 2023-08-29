<?php 
namespace App\Repositories\Vendor;
use App\Models\Product;
use App\Models\ProductTemp;
use App\Models\ProductImage;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Enums\ProductStatus;

class ProductRepository{

	public function __construct(public LogService $logger){}

	public function getAll()
	{
		return Product::where('vendor_id',auth()->user()->vendor_id)->get();
	}
	public function getAllWithPagination(Request $request,$pagination=10)
	{
		$query = Product::where('vendor_id',auth()->user()->vendor_id);
		if ( isset($request->search) ) {
			$query = $query->where('name->'.app()->getLocale(),'LIKE','%'.$request->search.'%');
		}
		return $query->paginate($pagination);
	}

	public function getProductsPaginated(int $perPage = 10, $sort = 'desc',$request = null,)
    {
        $sort = strtolower($sort);
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $search = $request->has('search') ? $request->search : null;
        return Product::where('vendor_id',auth()->user()->vendor_id)->when(
                $search,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->where('name->ar', 'like', "%$search%")
                        ->orWhere('name->en', 'like', "%$search%")
                )
            )
            ->when(
                $request->has('active_status') && $request->active_status != 'all',
                fn($q) => $q->where('is_active', $request->active_status == "active" ? 1 : 0)
            )->when(
                $request->has('type') && $request->type == 'temp',
                fn($q) => $q->has('temp')
            )->when(
                $request->has('type') && $request->type == 'pending',
                fn($q) => $q->where('status',ProductStatus::PENDING)
            )
            ->when(
                $request->has('created_date'),
                function ($q) use ($request) {
                    $dateRange = explode(" to " ,$request->created_date);
                    if (count($dateRange) == 2) {
                        $dateFrom = Carbon::parse($dateRange[0])->format("Y-m-d");
                        $dateTo = Carbon::parse($dateRange[1])->format("Y-m-d");
                        $dateFrom = $dateFrom ." 00:00:00";
                        $dateTo = $dateTo ." 23:59:59";
                        $q->when(
                            $dateFrom && $dateTo,
                            fn($subQ) => $subQ->where('created_at', '>=', $dateFrom)->where('created_at', '<=', $dateTo)
                        );
                    }
                }
            )
            ->orderBy('id', $sort)
            ->paginate($perPage);
    }

	public function countAll()
	{
		return Product::where('vendor_id',auth()->user()->vendor_id)->count();
	}
	public function find($id, array $relations = [])
	{
		$product = Product::with($relations)->findOrFail($id);
		$product->ar=['name'=>$product->getTranslation('name','ar'),'desc'=>$product->getTranslation('desc','ar')];
		$product->en=['name'=>$product->getTranslation('name','en'),'desc'=>$product->getTranslation('desc','en')];
		$reviews_count=$product->reviews()->count();
        $product->reviews_count=($reviews_count>0)?$reviews_count : 1;
        $product->some_reviews=$product->reviews()->limit(10)->get();
        $product->new_images=[];
        if($product->temp)
        {
            $product->new_images=array_diff($product->temp->images_array(),$product->images()->pluck('id')->toArray());
        }
		return $product;
	}

	public function store($data)
	{
		$data['vendor_id']=auth()->user()->vendor_id;
        $data['price'] = $data['price'] * 100;
        if (isset($data['price_before_offer'])) $data['price_before_offer'] = $data['price_before_offer'] * 100;

		$row=Product::create($data);
		if (isset($data['images_array']) && isset($data['images_array'][0])) {
			$images = explode(',', $data['images_array'][0]);
			foreach($images as $image_id )
				ProductImage::where('id',$image_id)->update(['product_id'=>$row->id]);
		}
		return $row;
	}

	public function update($data,$id)
	{
		$row = Product::with(['category','subCategory','finalSubCategory','quantity_type','type'])->findOrFail($id);
        $data['price'] = $data['price'] * 100;
        if (isset($data['price_before_offer'])) $data['price_before_offer'] = $data['price_before_offer'] * 100;

        if ($row->status == 'accepted') {
			
			$temp=$this->createProductTemp($row,$data);
			
			$this->saveUpdatedData($temp,$row);
			
			$row->update(['is_visible'=>$data['is_visible']]);

        }else{
        	$row->update($data);
        }


		return $row;
	}

	public function delete($id)
	{
		Product::where('id',$id)->delete();
		return true;
	}

	private function createProductTemp($product,$data)
	{
		$productData=[
			'status'=>'pending',
			'vendor_id'=>$product->vendor_id,
			'product_id'=>$product->id,
			'name'=>$data['name'],
			'desc'=>$data['desc'],
			'category_id'=>$data['category_id'],
			'quantity_type_id'=>$data['quantity_type_id'],
			'type_id'=>$data['type_id'],
			'sub_category_id'=>$data['sub_category_id'],
			'final_category_id'=>$data['final_category_id']
		];

		if (isset($data['image'])) {
			$productData['image']=$data['image'];
		}

		$productTemp=array_merge(['data'=>json_encode($data)],$productData);
		if ($product->productTemp != null) {
			$product->productTemp->update($productTemp);
			$temp=$product->productTemp;
		}else{
			$temp=ProductTemp::create($productTemp);
		}
		$this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "updateProduct",
            'model_type' => "\App\Models\Product",
            'model_id' => $product->id,
            'object_before' => $product,
            'object_after' => $temp
        ]);
        return $temp;

	}
	private function saveUpdatedData($temp,$product)
	{
		$tempData = array_diff_key(json_decode($temp->data,true), array_flip(["name", "desc", "images_array","deleted_images_array","formAction","_method","_token"]));
        $tempData['image']=$temp->image;
		
		$productOldData=$product;
		$productOldData = $productOldData->setHidden(['vendor','created_at','updated_at','product_temp','name','desc'])->toArray();
		$productCollection=collect($tempData);

		$diff = $productCollection->diffAssoc($productOldData)->all();

		foreach(config()->get('app.locales') as $local)
		{
			if ($product->getTranslation('name',$local) != $temp->getTranslation('name',$local)) {
				$diff['name_'.$local]=$temp->getTranslation('name',$local);
			}
			if ($product->getTranslation('desc',$local) != $temp->getTranslation('desc',$local)) {
				$diff['desc_'.$local]=$temp->getTranslation('desc',$local);
			}
		}
		$temp->updated_data=json_encode($diff);
		$temp->save();
	}

}


?>