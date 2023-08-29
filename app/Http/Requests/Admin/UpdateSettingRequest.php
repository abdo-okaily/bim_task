<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SettingEnum;
class UpdateSettingRequest extends FormRequest
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
            "facebook" =>  SettingEnum::getKeyValidation(   SettingEnum::facebook ),
            "instagram" => SettingEnum::getKeyValidation(   SettingEnum::instagram ),
            "twitter" => SettingEnum::getKeyValidation(   SettingEnum::twitter ),
            "site_name" => SettingEnum::getKeyValidation(   SettingEnum::site_name ),
            "site_name_en" => SettingEnum::getKeyValidation(   SettingEnum::site_name_en ),
            // "seo_desc" => SettingEnum::getKeyValidation(   SettingEnum::seo_desc ),
            // "seo_keys" => SettingEnum::getKeyValidation(   SettingEnum::seo_keys ),
            "recipes_book" => SettingEnum::getKeyValidation(   SettingEnum::recipes_book ),
            "recipes_page_desc" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc ),
            "recipes_page_desc_en" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc_en ),
            "recipes_page_title" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title ),
            "recipes_page_title_en" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title_en ),
            "site_logo" => SettingEnum::getKeyValidation(   SettingEnum::site_logo ),
            "browser_logo" => SettingEnum::getKeyValidation(   SettingEnum::browser_logo ),
            "footer_logo" => SettingEnum::getKeyValidation(   SettingEnum::footer_logo ),
            "footer_logo2" => SettingEnum::getKeyValidation(   SettingEnum::footer_logo2 ),
           // "phone" => SettingEnum::getKeyValidation(   SettingEnum::phone ),
            "email" => SettingEnum::getKeyValidation(   SettingEnum::email ),
            "address" => SettingEnum::getKeyValidation(   SettingEnum::address ),
            "working_time" => SettingEnum::getKeyValidation(   SettingEnum::working_time ),
            "working_time_en" => SettingEnum::getKeyValidation(   SettingEnum::working_time_en ),
            "vat" => SettingEnum::getKeyValidation(   SettingEnum::vat ),
            "terms_ar" => SettingEnum::getKeyValidation(   SettingEnum::terms_ar ),
            "terms_en" => SettingEnum::getKeyValidation(   SettingEnum::terms_en ),
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
            'recipes_book.mimes' => trans('admin.settings.validations.pdf'),
            
        ];
    }
}
