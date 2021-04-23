<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Atc
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
        if ((in_array('ATC', explode(', ', auth()->user()->roles))) || (in_array('Visiting ATC', explode(', ', auth()->user()->roles))) ) {
            return $next($request);
        }else{
            return redirect()->route('home')->with('permission', 'No access');
         }
    }
}
