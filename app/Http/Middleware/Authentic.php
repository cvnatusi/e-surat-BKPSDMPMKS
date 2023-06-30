<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authentic
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
        if(Auth::check()){
            return $next($request);
        }else{
            $url = route('login').'?next_url='.$request->path();
            return redirect($url);
        }
        // $url = route('suspended');
        // return redirect($url);
    }
}
