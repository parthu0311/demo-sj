<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $route = $request->route();
        $actions = $route->getAction();



        //echo ; exit;
        if($request->session()->get('userData') && !empty($request->session()->get('userData')->id) ){
            if($actions['middleware'] == "web" && $actions['prefix'] = "/admin"){
                return redirect('admin');
            }
        }/*elseif( $request->session()->get('CustomerData') && !empty($request->session()->get('CustomerData')->id) ){
            return redirect('/');
        }*/

        return $next($request);
    }
}
