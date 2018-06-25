<?php namespace App\Http\Middleware;

use Closure;
/*use Illuminate\Contracts\Auth\Guard;*/
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	/*public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}*/

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
        $route = $request->route();
        $actions = $route->getAction();

		if (Auth::guard($guard)->guest()) {
                    //print_r($request->session()->get('userData'));exit;
                    if($request->session()->get('userData') && !empty($request->session()->get('userData')->id) ){
                       //return redirect('admin');
                    }else{
                        return redirect('/admin/login');
                    } 

                }
                return $next($request);
    }
}
