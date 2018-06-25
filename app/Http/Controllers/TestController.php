<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Http\Helper;
use Mail;
use Folklore\Image\Facades\Image as Image;

use App\GeneralSettings;
use App\Brand;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Softon\Indipay\Facades\Indipay;

class TestController extends Controller {

    public function __construct() {

    }

    public function CCAvanue(Request $request) {
        $parameters = [

            'tid' => '1233221223322',

            'order_id' => '1232212',

            'amount' => '1200.00',

        ];

        // gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo / ZapakPay / Mocker


        $order = Indipay::gateway('CCAvenue')->prepare($parameters);
        return Indipay::process($order);
    }

}
