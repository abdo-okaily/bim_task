<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
            'name_ar' => ["required", "string", "min:3"],
            'name_en' => ["required", "string", "min:3"],
            'area_id' => ["required"],
            'torod_city_id' => ["string"],
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
            "name_ar.required" => trans("admin.countries.validations.name_ar_required"),
            "name_ar.string" => trans("admin.countries.validations.name_ar_string"),
            "name_ar.min" => trans("admin.countries.validations.name_ar_min"),
            "name_en.required" => trans("admin.countries.validations.name_en_required"),
            "name_en.string" => trans("admin.countries.validations.name_en_string"),
            "name_en.min" => trans("admin.countries.validations.name_en_min"),
            "area_id.required" => trans("admin.cities.validations.area_id_required"),
            "torod_city_id.string" => trans("admin.cities.validations.torod_city_id_string"),
        ];
    }
}
