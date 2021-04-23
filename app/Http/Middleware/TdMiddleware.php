<?php

namespace App\Http\Middleware;

use Closure;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class TdMiddleware
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
        if ((in_array('TD', explode(', ', auth()->user()->roles)))) {
            return $next($request);
        }else{
            return redirect()->route('home')->with('permission', 'No access');
         }
    }
}
