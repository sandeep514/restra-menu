<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
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
       if(!Auth::guard('is_admin')->check()){
        return $next($request);
     }
      return redirect('/')->with('error',"You don't have admin access.");
     // abort(403, "Cannot access to restricted page");
        // if(!Auth::guard('is_admin')->check()){
        //     return redirect()->route('home');
        // }
        // return $next($request);
}
}
