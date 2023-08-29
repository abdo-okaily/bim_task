<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\HelpdeskService;
use  App\Http\Requests\Api\SendInqueryRequest;

class HelpdeskController extends ApiController
{

    public function __construct(public HelpdeskService $service) {
        // $this->middleware('api.auth');
    }


    public function contact_us(SendInqueryRequest $request)
    {
       if(  $this->service->sendInquery($request) == true)
       {
        return $this->setApiResponse
        (
            true,
            200,
            [],
            __('helpdesk.api.request_send_successfully')
        );
       }
    }

    public function info()
    {
        $settings  = $this->service->getContactInfo();
        return $this->setApiResponse
        (
            $settings['success'],
            $settings['status'],
            $settings['data'],
            $settings['message']
        );
       
    }





}
