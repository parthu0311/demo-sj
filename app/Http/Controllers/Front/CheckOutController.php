<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class CheckOutController extends Controller
{
    /**
     * @param $productId
     * @return mixed
     */
    private function productImage($productId)
    {
        return view('front.checkout');
    }


}