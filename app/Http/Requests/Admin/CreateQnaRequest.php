<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateQnaRequest extends FormRequest
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
            'question_ar' => ["required", "string", "min:3",'max:600'],
            'question_en' => ["required", "string", "min:3",'max:600'],
            'answer_ar' => ["required", "string", "min:3",'max:1000'],
            'answer_en' => ["required", "string", "min:3",'max:1000'],
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
            "question_ar.required"  => trans("admin.qnas.validations.question_ar_required"),
            "question_ar.string"    => trans("admin.qnas.validations.question_ar_string"),
            "question_ar.min"       => trans("admin.qnas.validations.question_ar_min"),
            "question_ar.max"       => trans("admin.qnas.validations.question_ar_max"),

            "answer_ar.required" => trans("admin.qnas.validations.answer_ar_required"),
            "answer_ar.string" => trans("admin.qnas.validations.answer_ar_string"),
            "answer_ar.min" => trans("admin.qnas.validations.answer_ar_min"),
            "answer_ar.max" => trans("admin.qnas.validations.answer_ar_max"),


            "question_en.required" => trans("admin.qnas.validations.question_en_required"),
            "question_en.string" => trans("admin.qnas.validations.question_en_string"),
            "question_en.min" => trans("admin.qnas.validations.question_en_min"),            
            "question_en.max" => trans("admin.qnas.validations.question_en_max"),

            "answer_en.required" => trans("admin.qnas.validations.answer_en_required"),
            "answer_en.string"   => trans("admin.qnas.validations.answer_en_string"),
            "answer_en.min"      => trans("admin.qnas.validations.answer_en_min"),
            "answer_en.max"      => trans("admin.qnas.validations.answer_en_mmax"),
            
            
        ];
    }
}
