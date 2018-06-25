<?php

namespace App\Http\Controllers;

use App\Products;
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

use Adminuser;
use App\GeneralSettings;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class SliderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    public function productSliderview(){
        $permission = Helper::checkActionPermission('admin', 'product-sliders');
        if ($permission === 0) {
            return view('error.301');
        }
        $product_slider = GeneralSettings::where('id',1)->select('product_slider')->first();
        return view('admin/sliders/productsliderList',['product_slider' => $product_slider]);
    }
    public function getSliderUserList(Request $request){

        $products = Products::select(['id','product_name','product_code'])->where('is_slider','Yes')->where('status','Active')->get();
        return Datatables::of($products)

            ->filter(function ($instance) use ($request) {


                if ($request->has('product_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['product_name'], $request->get('product_name')) ? true : false;
                    });
                }

                if ($request->has('product_code')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['product_code'], $request->get('product_code')) ? true : false;
                    });
                }

            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProductSlider() {
        $permission = Helper::checkActionPermission('slider', 'CreateProductSlider');
        if ($permission === 0) {
           return view('error.301');
        }

        return view('admin/sliders/createproductslider');
     
    }

    public function getProductJson(Request $request)
    {
        $products = Products::where('status','Active')
            ->select('product_name','id')
            ->where('is_slider','No')
            ->where('product_name','like','%' . $request->keyword . '%')
            ->get();
        return $products;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProductSlider(Request $request) {
        $permission = Helper::checkActionPermission('slider', 'storeProductSlider');
        if ($permission === 0) {
            return view('error.301');
        }
		
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        $users = Products::where('id',$request->product_id)->update(
                [
                    'is_slider' => 'Yes'
                ]
        );
        return redirect('admin/product-sliders');
    }

    public function changeProductSliderStatus(Request $request) {
        $permission = Helper::checkActionPermission('slider', 'changeProductSliderStatus');
        if ($permission === 0) {
            return view('error.301');
        }
         GeneralSettings::where('id',1)->update(
            [
                'product_slider' => $request->status
            ]
        );
       // echo $request->status;
//        /return redirect('admin/product-sliders');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProductSlider(Request $request) {
        $permission = Helper::checkActionPermission('slider', 'delete-product-slider');
        if ($permission === 0) {
            return view('error.301');
        }

        $users = Products::where('id',$request->id)->update(
            [
                'is_slider' => 'No'
            ]
        );

        return view('admin/product-sliders');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminreate\Http\Response
     */



 
}
