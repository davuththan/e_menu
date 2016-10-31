<?php

namespace App\Http\Middleware;

use Closure;

class GlobalConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {	
    	$configs = \DB::table('config')->get();
    	foreach ($configs as $key => $config) {
    		define($config->keywords, $config->value);
    	}
        return $next($request);
    }
}
