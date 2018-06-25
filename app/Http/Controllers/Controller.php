<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function engineer_details(){
        /*$InternalData = $_COOKIE['InternalData'];
        $User_ID = "";
        if(isset($InternalData) && !empty($InternalData)){
            $User_ID = $InternalData->id;
            View::share("User_ID","$InternalData->id");
        }
        echo $User_ID;exit;*/
    }
}
