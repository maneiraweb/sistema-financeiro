<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use SisFin\Models\User;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    public function accessToken(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if($token = Auth::guard('api')->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function refreshToken(Request $request) {
        $token = Auth::guard('api')->refresh();
        return $this->sendLoginResponse($request, $token);
    }

    protected function sendLoginResponse(Request $request, $token) {
        
        $this->clearLoginAttempts($request);
        
        return response()->json([
            'token' => $token
        ]);
    }

    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json([
            'message' => $message
        ], 403);
    }

    protected function sendFailedLoginResponse(Request $request) {
        return response()->json([
            'message' => Lang::get('auth.failed')
        ], 400);
    }

    public function logout(Request $request) {
        Auth::guard('api')->logout();
        return response()->json([], 204);
    }

}
