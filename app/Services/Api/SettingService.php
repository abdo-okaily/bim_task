<?php

namespace App\Services\Api;

use App\Http\Resources\Api\SliderImageResource;
use App\Http\Resources\Api\SettingResource;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use App\Repositories\SliderRepository;
use  Illuminate\Http\Api\SendInqueryRequest;
use  Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingService
{


    public function __construct(
        public SliderRepository $sliderRepository,
        public SettingRepository $settingRepository) {}


    public function homePageSlider()
    {
        $slider = $this->sliderRepository->all()->where('identifier','HOME_PAGE_SLIDER')->first();
            
        if($slider == null)
        {   
            return [     
                        'success'=>false,
                        'status'=>404 ,
                        'data'=> [],
                        'message'=>''
                ];
        }

      
        return [        'success'=>true,
                        'status'=>200 ,
                        'data'=> SliderImageResource::collection($slider->getMedia('sliders') ),
                        'message'=>''
        ];
    }


    public function websiteSetting()
    {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();
        
        $data = [] ;
        $data['browser_logo'] =url($settings['browser_logo'])?? "";
        $data['seo_desc'] = (Config::get('app.locale') == 'ar' ) ? $settings['seo_desc'] : $settings['seo_desc_en'];
        $data['seo_keys'] = (Config::get('app.locale') == 'ar' ) ? $settings['seo_keys'] : $settings['seo_keys_en'];
        $data['site_name'] = (Config::get('app.locale') == 'ar' ) ? $settings['site_name'] : $settings['site_name_en'];
        
        return [         
            'success'=>true ,
            'status'=>200 ,
            'data'=> $data,
            'message'=>__('api.settings.retrived')
            ];
    }


    

    public function contactInfo()
    {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();

        $info = [] ;
        

        $info['phone'] =$settings['phone'];
        $info['email'] =$settings['email'];
        $info['facebook'] =$settings['facebook'];
        $info['twitter'] =$settings['twitter'];
        $info['instagram'] =$settings['instagram'];
        $info['address'] = (Config::get('app.locale') == 'ar')  ?  $settings['address'] : $settings['address_en'];
        $info['working_time'] = (Config::get('app.locale') == 'ar') ? $settings['working_time'] : $settings['working_time_en'];
        
        return [         
            'success'=>true ,
            'status'=>200 ,
            'data'=> $info,
            'message'=>__('api.settings.retrived')
            ];
    }


    
    public function mainData()
    {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();

        $info = [] ;

        $info['vendor_login_page'] =$settings['vendor_login_page'];
        $info['footer_logo'] =url($settings['footer_logo']);
        $info['footer_logo2'] =url($settings['footer_logo2']);
        $info['site_logo'] =url($settings['site_logo']);
        $info['facebook'] =$settings['facebook'];
        $info['twitter'] =$settings['twitter'];
        $info['instagram'] =$settings['instagram'];
        $info['phone'] =$settings['phone'];
        
        return [         
            'success'=>true ,
            'status'=>200 ,
            'data'=> $info,
            'message'=>__('api.settings.retrived')
            ];
    }
    

    
}

