<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function login(Request $request): RedirectResponse
    {   
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (auth()->user()->role == 'approval') {
                return redirect()->route('approval.home');
            }else if (auth()->user()->role == 'partner') {
                return redirect()->route('partner.home');
            }else if (auth()->user()->role == 'customer') {
                return redirect()->route('customer.home');
            }else if (auth()->user()->role == 'director') {
                return redirect()->route('director.home');
            }else{
                return redirect()->route('index');
            }
        } else {
            return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
        }
    }

    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
 
        return redirect('login')->withSuccess('Berhasil Logout!');
    }

    protected function redirectTo()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return route('admin.home');
            case 'approval':
                return route('approval.home');
            case 'partner':
                return route('partner.home');
            case 'customer':
                return route('customer.home');
            default:
                return route('index');
        }
    }
}
