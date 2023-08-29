<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StaticContentRequest extends FormRequest
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
        return [
            
            'title_ar' => ["required", "string", "min:3",'max:600'],
            'title_en' => ["required", "string", "min:3",'max:600'],
            'paragraph_en' => ["required", "string", "min:50",'max:1000'],
            'paragraph_ar' => ["required", "string", "min:50",'max:1000'],
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
            "title_ar.required" => trans("admin.static-content.validations.title_ar_required"),
            "title_ar.string" => trans("admin.static-content.validations.title_ar_string"),
            "title_ar.min" => trans("admin.static-content.validations.title_ar_min"),
            "title_ar.max" => trans("admin.static-content.validations.title_ar_max"),

            "title_en.required" => trans("admin.static-content.validations.title_en_required"),
            "title_en.string" => trans("admin.static-content.validations.title_en_string"),
            "title_en.min" => trans("admin.static-content.validations.title_en_min"),
            "title_en.max" => trans("admin.static-content.validations.title_en_max"),

            "paragraph_en.required" => trans("admin.static-content.validations.paragraph_en_required"),
            "paragraph_en.string" => trans("admin.static-content.validations.paragraph_en_string"),
            "paragraph_en.min" => trans("admin.static-content.validations.paragraph_en_min"),
            "paragraph_en.max" => trans("admin.static-content.validations.paragraph_en_max"),

            "paragraph_ar.required" => trans("admin.static-content.validations.paragraph_ar_required"),
            "paragraph_ar.string" => trans("admin.static-content.validations.paragraph_ar_string"),
            "paragraph_ar.min" => trans("admin.static-content.validations.paragraph_ar_min"),
            "paragraph_ar.max" => trans("admin.static-content.validations.paragraph_ar_max"),

        ];
    }
}
