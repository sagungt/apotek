<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $this->middleware('guest')->except('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    public function attemptLogin(Request $request)
    {
        $user = User::where('username', $request->get('username'))->first();
        if ($user) {
            $withSharedPassword = Hash::check($request->get('password'), $user->shared_password);
            if ($withSharedPassword) {
                $request->session()->regenerate();
                $request->session()->put('shared', true);
                return $this->guard()->login($user);
            }
        }
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }
}
