<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageTitle {

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
	public function __construct(Guard $auth)
	{
		//$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
        $Prefix = $request->route()->getPrefix();

		$route = $request->path();
        $route = explode('/',$route);
        if($Prefix == ""){
            if($route[0] == 'customer-dashboard'){
                View::share('page_title','<i class="flaticon flaticon-web-page-home title_icon"></i>Home');
            }elseif ($route[0] == 'product-list'){
                View::share('page_title','<i class="flaticon flaticon-squares title_icon"></i>Product List');
            }elseif ($route[0] == 'product-custom-rfq' || $route[0] == 'product-custom' || $route[0] == 'pending-inquiries'){
                View::share('page_title','<i class="flaticon flaticon-write title_icon"></i>Request Quote');
            }elseif ($route[0] == 'product-detail'){
                View::share('page_title','<i class="flaticon flaticon-squares title_icon"></i>Product Details');
            }elseif ($route[0] == 'customer-cart'){
                View::share('page_title','<i class="flaticon flaticon-shopping-cart title_icon"></i>Cart');
            }else{
                View::share('page_title','');
            }
        }elseif ($Prefix == "/internal"){
            if($route[1] == 'internal-dashboard'){
                View::share('page_title','<i class="flaticon flaticon-web-page-home title_icon"></i>Home');
            }else if($route[1] == 'claim-rfq'){
                View::share('page_title','<i class="flaticon flaticon-invoice title_icon"></i>Claim RFQ');
            }else if($route[1] == 'customer-manage'){
                View::share('page_title','<i class="flaticon flaticon-repair-tools  title_icon"></i>Customer Management');
            }else if($route[1] == 'active-rfq'){
                View::share('page_title','<i class="flaticon flaticon-invoice title_icon"></i>Active RFQs');
            }else if($route[1] == 'create-quotes'){
                View::share('page_title','<i class="flaticon flaticon-write title_icon"></i>Create Quotes');
            }else if($route[1] == 'active-quotes'){
                View::share('page_title','<i class="flaticon flaticon-write title_icon"></i>Active Quotes');
            }else if($route[1] == 'quotes-status'){
                View::share('page_title','<i class="flaticon flaticon-write title_icon"></i>Quote Status');
            }else if($route[1] == 'management-rfq'){
                View::share('page_title','<i class="flaticon flaticon-invoice title_icon"></i>RFQs');
            }else{
                View::share('page_title','');
            }
        }else{
            View::share('page_title','');
        }


		return $next($request);

	}



}
