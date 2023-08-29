<?php

namespace App\Http\Requests\Admin;

use App\Enums\CountryStatus;
use App\Enums\NationalCountry;
use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
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
            'code' => ["required", "string", "min:2"],
            'vat_percentage' => ["required", "numeric", "min:0", "max:99.99"],
            'is_active' => ["required", "in:". CountryStatus::ACTIVE .",". CountryStatus::INACTIVE],
            'is_national' => ["required", "in:". NationalCountry::NATIONAL .",". NationalCountry::NOTNATIONAL]
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
            "code.required" => trans("admin.countries.validations.code_required"),
            "code.string" => trans("admin.countries.validations.code_string"),
            "code.min" => trans("admin.countries.validations.code_min")
        ];
    }

    public function attributes()
    {
        return [
            "vat_percentage" => "(". trans("admin.countries.vat_percentage") .")",
            "is_active" => "(". trans("admin.countries.is_active") .")",
            "is_national" => "(". trans("admin.countries.is_national") .")",

        ];
    }
}
