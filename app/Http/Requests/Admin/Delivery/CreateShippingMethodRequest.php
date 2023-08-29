<?php

namespace App\Http\Requests\Admin\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ShippingMethodKeys;
use App\Enums\ShippingMethodType;

class CreateShippingMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "name_ar" => "required|string|min:3|max:250",
            "name_en" => "required|string|min:3|max:250",
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'integration_key' => 'required|unique:shipping_methods,integration_key|in:'. implode(',',ShippingMethodKeys::getKeysArray()),
            "delivery_fees" => "required|numeric|min:0|max:10000000",
            'delivery_fees_covered_kilos' => 'nullable|numeric|min:0|max:10000000',
            'additional_kilo_price' => "required|numeric|min:0|max:10000000",
            'cod_collect_fees' => "required|numeric|min:0|max:10000000",
            'type' => 'required|in:'.implode(',',ShippingMethodType::getTypes()),
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "name_ar" => "(". __('admin.shippingMethods.name_ar') .")",
            "name_en" => "(". __('admin.shippingMethods.name_en') .")",
            "logo" => "(". __('admin.shippingMethods.logo') .")",
            "integration_key" => "(". __('admin.shippingMethods.integration_key') .")",
            "delivery_fees" => "(". __('admin.shippingMethods.delivery_fees') .")",
            "delivery_fees_covered_kilos" => "(". __('admin.shippingMethods.delivery_fees_covered_kilos') .")",
            "additional_kilo_price" => "(". __('admin.shippingMethods.additional_kilo_price') .")",
            "cod_collect_fees" => "(". __('admin.shippingMethods.cod_collect_fees') .")",
            "type" => "(". __('admin.shippingMethods.type') .")",
        ];
    }
}
