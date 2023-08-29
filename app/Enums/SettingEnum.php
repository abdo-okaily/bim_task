<?php
namespace App\Enums;

class SettingEnum {
    const vat = 'vat';
    const terms_ar = 'terms_ar';
    const terms_en = 'terms_en';

    
    const phone = 'phone';
    const email = 'email';
    const address = 'address';
    const address_en = 'address_en';
    
    const working_time = 'working_time';
    const working_time_en = 'working_time_en';
    
    const facebook = 'facebook';
    const instagram = 'instagram';
    const twitter = 'twitter';
    const site_name = 'site_name';
    const site_name_en = 'site_name_en';
    
    const seo_desc = 'seo_desc';
    const seo_desc_en = 'seo_desc_en';
    const seo_keys = 'seo_keys';
    const seo_keys_en = 'seo_keys_en';
    const site_logo = 'site_logo';
    const browser_logo = 'browser_logo';
    const footer_logo = 'footer_logo';
    const footer_logo2 = 'footer_logo2';
    const recipes_book = 'recipes_book';
    const recipes_page_desc = 'recipes_page_desc';
    const recipes_page_desc_en = 'recipes_page_desc_en';
    
    const recipes_page_title = 'recipes_page_title';
    const recipes_page_title_en = 'recipes_page_title_en';
    const vendor_login_page = 'vendor_login_page';
    const vendor_terms = 'vendor_terms';

    

    public static function getKeyValidation(string $key) : string|array|null {
        switch($key) {
            case self::vat:
                return "required|min:0|max:100|numeric";
            case self::facebook:
            case self::instagram:
            case self::twitter:
            case self::site_name:
            case self::site_name_en:
            case self::vendor_login_page:
            case self::address:
            case self::address_en: 
                return "required|string|min:3|max:190";
            case self::terms_ar:
            case self::terms_en:
            case self::working_time:
            case self::working_time_en:
            case self::seo_desc:
            case self::seo_desc_en:
            case self::seo_keys:
            case self::seo_keys_en:
            case self::recipes_page_desc_en:
            case self::recipes_page_desc:
            case self::recipes_page_title:
            case self::recipes_page_title_en:
                return "required|string|min:3|max:1400";
            case self::phone:
                return [
                    "required",
                    "regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/"
                ];
            case self::email:
                return "required|email|max:190";
            case self::site_logo:
            case self::browser_logo:
            case self::footer_logo:
            case self::footer_logo2:
                return "image|max:2048";
            case self::recipes_book:
                return "mimes:pdf|max:4096";
        }
        return null;
    }
}