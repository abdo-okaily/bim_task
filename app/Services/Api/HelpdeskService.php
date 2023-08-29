<?php

namespace App\Services\Api;

use App\Models\Setting;
use  Illuminate\Http\Api\SendInqueryRequest;
use  Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class HelpdeskService
{

    public  function  sendInquery(Request $request)
	{

		$response =  Http::withHeaders([
			'Accept'  =>  "application/json",
			'Content-Type'  =>  "application/json"
		])->post(config("help-disk.api_url"), [
			'token'  =>  config("help-disk.access_token"),
			'title'  => $request->title,
			'desc'   => $request->desc,
			'category'  => ($request->category ==  "الاستفسارات") ?  config("help-disk.category_token.inquiries_token") :  config("help-disk.category_token.complaints_token"),
			'user_type'  => (!empty(auth('api')->user())) ?  "عميل"  :  "زائر",
			'name'   => auth('api')->user()->name    ?? $request->name,
			'email'  => auth('api')->user()->email   ?? $request->email,
			'phone'  => auth('api')->user()->phone   ?? $request->phone,
			'file'   => $request->file
		]);
		return  response($response->json(),  $response->status());
	}


    
}

