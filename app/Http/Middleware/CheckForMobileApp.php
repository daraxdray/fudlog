<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 10/01/2021 - CheckForMobileApp.php
 */

namespace App\Http\Middleware;

use Closure;

class CheckForMobileApp
{

    public function handle($request, closure $next)
    {
         if (isset($request->xmd) && $request->xmd === env("MOBILE_AGENT")) {
            session(['isMobile'=> true]); 
            isMobileLogin();
        } 
            //remember to remove this line to keep long notice of the device
            return $next($request);
    }

}