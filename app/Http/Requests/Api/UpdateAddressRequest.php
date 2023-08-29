<?php

namespace App\Http\Requests\Api;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateAddressRequest
 extends FormRequest
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
        $isCountryNational =  request()->country_id ? Country::find(request()->country_id)->is_national: false;
        return [

            'type'       =>'nullable|in:work,home',
            'address_id' =>'required',
            'phone'      =>'required|phone:AUTO|numeric',
            'international_city' => Rule::requiredIf(!$isCountryNational)

        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => __('validation.first_name-required') ,
            'first_name.required'  => __('validation.last_name-required'),
            'description.required'  => __('validation.description-required'),
            'type.in' =>__('validation.invalid_type'),
            'type.required'  => __('validation.type-required'),
            'lat.required'  => __('validation.lat-required'),
            'long.required'  => __('validation.long-required'),
            'phone.phone'  => __('validation.phone-invalid'),

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => trans('customer.validation_errors'),
            "status"    => 422,
            'data'      => $validator->errors()

        ],422));
    }
}
