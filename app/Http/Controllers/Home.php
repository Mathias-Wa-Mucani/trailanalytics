<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class Home extends Controller
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
    // use AuthenticatesUsers;
    // use AuthenticatesUsers {
    //     logout as performLogout;
    // }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        return  Response::json(['res'=>'hello world']);
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => request()->email,
            'password' => request()->password,
            // 'active' => 1
        ];
    }

    protected function authenticated()
    {
        /**
         * Check if user email is verified
         */
        if (!Auth::user()->email_verified_at) {
            Auth::logout();
            return redirect('login')->withErrors(['Please verify your email']);
        }

        /**
         * Check if user account is active
         */
        // else if (!Auth::user()->active) {
        //     Auth::logout();
        //     return redirect('login')->withErrors(['Your account is inactive']);
        // }

        // else if(auth()->user()){

        // }
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('home');
    }
}
