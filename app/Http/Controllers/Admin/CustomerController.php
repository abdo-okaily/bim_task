<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pipeline\Pipeline;

class CustomerController extends Controller
{
    //
    public $logger;

    public function __construct(LogService $logger){
        $this->logger = $logger;
    }

    public function index(Request $request)
    {
        $query = User::with(['transactions','addresses'])->where(['type' => 'customer']);

        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Admin\Customer\FilterName::class,
                \App\Pipelines\Admin\Customer\FilterEmail::class,
                \App\Pipelines\Admin\Customer\FilterPhone::class,
            ])
            ->thenReturn();
        $customers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.customer.index',['customers' => $customers]);
    }

    public function show(User $user)
    {
        return view('admin.customer.show',[
            'customer' => $user,
            'breadcrumbParent' => 'admin.customers.index',
            'breadcrumbParentUrl' => route('admin.customers.index')
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.customer.edit',[
            'customer' => $user,
            'breadcrumbParent' => 'admin.customers.index',
            'breadcrumbParentUrl' => route('admin.customers.index')
        ]);
    }

    public function update(User $user)
    {
        $customer_attributes = request()->all();
        $update_array = [];

        $user_rules = [
            'name' => 'min:3',
            'email'=>'nullable|email|unique:users,email,'.$user->id,
            'phone'=>'nullable|min:9|unique:users,phone,'.$user->id,
        ];
        $validator = Validator::make($customer_attributes, $user_rules);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $update_array['name'] = $customer_attributes['name'];
        $update_array['phone'] = $customer_attributes['phone'];
        $update_array['email'] = $customer_attributes['email'];
        $user->update($update_array);

        return redirect(route('admin.customers.index'));
    }

    public function changePriority(User $user): \Illuminate\Http\JsonResponse
    {
        $old_user = User::find($user->id);
        $user->priority = request()->all()['priority'];
        $user->save();
        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "changePriority",
            'model_type' => "\App\Models\User",
            'model_id' => $user->id,
            'object_before' => $old_user,
            'object_after' => $user
        ]);
        return response()->json(['status' => 'success','data' => $user->priority],200);
    }

    public function block(User $user): \Illuminate\Http\JsonResponse
    {
        if($user->is_banned == 0)
        {
            $user->is_banned = 1;
            $message = __('admin.customer_blocked');
        }
        else
        {
            $user->is_banned = 0;
            $message = __('admin.customer_unblocked');
        }
        $user->save();
        return response()->json(['status' => 'success','data' => $user->is_banned,'message' => $message],200);
    }
}
