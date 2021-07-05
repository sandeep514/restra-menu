<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WaiterAuthenticate
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
       if(!Auth::guard('waiter')->check()){
            return redirect()->route('index');
        }
        return $next($request);
}
