<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon; 
use Auth; 
use Validator;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('is_admin')->except('logout');

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
              if (auth()->user()->role_id==1) { 
                   return redirect()->route('admin.home');
              }else if ((auth()->user()->role_id==2) && (auth()->user()->status==1) && (auth()->user()->expiry_date >= Carbon\Carbon::now()->toDateTimeString())) {
                  return redirect()->route('manager.dashboard');
                  
              }else if (auth()->user()->role_id==2 && auth()->user()->status==0) {
                return redirect()->route('login')->withErrors(['Login Errors', 'Sorry Your account blocked']);
              
               }else if (auth()->user()->role_id==2 && (auth()->user()>= Carbon\Carbon::now()->toDateTimeString())) {
                return redirect()->route('login')->withErrors(['Login Errors', 'Sorry Your Membership plan is expired']);
              }
               
            return redirect()->route('login')->withErrors(['Login Errors', 'Oops ! Invalid Credentials']);
        }else{
            return redirect()->route('login')->withErrors(['Login Errors', 'Oops ! Invalid Credentials']);
        }
      }


}
