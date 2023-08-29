<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $this->merge([
            'is_active' => $this->is_active == "on" ? true : false,
        ]);

        return [
            'name_ar' => ["required", "string", "min:3"],
            'name_en' => ["required", "string", "min:3"],
            'is_active' => ["boolean"],
            "image" => ["image","mimes:jpeg,png,jpg,gif,svg","max:2048"]
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
            "name_ar.required" => trans("admin.categories.validations.name_ar_required"),
            "name_ar.string" => trans("admin.categories.validations.name_ar_string"),
            "name_ar.min" => trans("admin.categories.validations.name_ar_min"),
            "name_en.required" => trans("admin.categories.validations.name_en_required"),
            "name_en.string" => trans("admin.categories.validations.name_en_string"),
            "name_en.min" => trans("admin.categories.validations.name_en_min"),
            "level.numeric" => trans("admin.categories.validations.level_numeric"),
            "level.between" => trans("admin.categories.validations.level_between"),
            "is_active.boolean" => trans("admin.categories.validations.is_active_boolean"),
            "image.required" => trans("admin.categories.validations.image_required"),
            "image.image" => trans("admin.categories.validations.image_image"),
            "image.mimes" => trans("admin.categories.validations.image_mimes"),
            "image.max" => trans("admin.categories.validations.image_max")
        ];
    }
}
