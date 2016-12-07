<?php

namespace SisFin\Http\Controllers\Auth;

use SisFin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function credentials(Request $request) {
        $data = $request->only($this->username(), 'password');
        $data['role'] = SisFin\User::ROLE_ADMIN;
        return $data;
    }

    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect(env('URL_ADMIN_LOGIN'));
    }

}
