<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$hasRoles)
    {
        $lanjut = false;
        
        if(\Roles::has($hasRoles)) $lanjut = true;

    	if($lanjut){
        //     \App\Helpers\MyHelper::logging($request);
            return $next($request);
    	}else {
            return abort(403);
        }
    }

}