<?php

namespace SisFin\Http\Middleware;

use Closure;

class AddClienteTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->is('api/*')){
            $user = \Auth::guard('api')->user();
            if($user){
                $cliente = $user->cliente;
                \Landlord::addTenant($cliente);
            }
        }
        return $next($request);
    }
}
