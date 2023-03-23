<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected function redirectTo()
    {
        if (auth()->user()->role == 0) {
            return route('admin.home');
        }

        if (auth()->user()->role == 1) {
            return route('user.home');
        }

        if (auth()->user()->role == 2) {
            return route('tech.home');
        }
        auth()->logout();
        return route('login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */

    public function username()
    {
        return 'phone';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
