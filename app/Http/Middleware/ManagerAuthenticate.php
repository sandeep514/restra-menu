<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Carbon; 

class ManagerAuthenticate
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
     if(!Auth::guard('manager')->check()){
        if ((Auth::user()->role_id==2) && (Auth::user()->status==1) && (Auth::user()->expiry_date >= Carbon\Carbon::now()->toDateTimeString())){
            return $next($request);
        }
        }
       return redirect('/')->with('error',"You don't have Manager access.");
    }
     // abort(403, "Cannot access to restricted page");
}
