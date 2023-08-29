<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'admin_comment' => ["nullable", "string", "min:3"],
            'admin_approved' => ["nullable", "numeric"],
            'admin_id' => ["nullable", "numeric"]
        ];
    }

    /**
     * Set Custom validation messages.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "admin_comment.string" => trans("admin.vendorRates.validations.admin_comment_string"),
            "admin_comment.min" => trans("admin.vendorRates.validations.admin_comment_min"),
            "admin_approved.boolean" => trans("admin.vendorRates.validations.admin_approved_boolean"),
            "admin_id.numeric" => trans("admin.vendorRates.validations.admin_id_numeric"),
        ];
    }
}
