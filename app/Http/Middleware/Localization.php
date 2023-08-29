<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /* Set new lang with the use of session */
        //  $lang = auth('api')->user() ?
        //      auth('api')->user()->lang
        //         : 'ar';
                
        
        // App::setLocale($lang);
        /* Set new lang with the use of session */
        
        if($request->header('lang') != null){
            App::setLocale($request->header('lang'));
        } else {
            App::setLocale('ar');
        }

        return $next($request);
    }
}
//cmd