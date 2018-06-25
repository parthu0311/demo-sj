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

class AdminProductBrandController extends Controller {

    public function __construct() {

    }

    public function brandCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'brand-create');
        if ($permission === 0) {
            return view('error.301');
        }



        return view('admin/brand/BrandCreate');
    }

    public function brandCreatePostData(Request $request){

        $this->validate($request, [
            'product_brand_code' => 'required|max:255',
            'product_brand_name' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Brand = new Brand();
        $Brand->product_brand_code = $request->product_brand_code;
        $Brand->product_brand_name = $request->product_brand_name;
        $Brand->status = $request->status;
        $Brand->created_date = Helper::get_curr_datetime();
        $Brand->created_by = $user_id;
        $Brand->save();

        $message = 'Product Brand is added.';
        return redirect('/admin/brand-list')->with('message', $message);
    }

    public function brandEdit($id){
        $permission = Helper::checkActionPermission('admin', 'brand-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $Brand = Brand::where('id', $id)->first();

        return view('admin/brand/BrandEdit', ['Brand' => $Brand]);
    }

    public function brandEditPost(Request $request,$id){

        $this->validate($request, [
            'product_brand_code' => 'required|max:255',
            'product_brand_name' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Brand = Brand::find($id);
        $Brand->product_brand_code = $request->product_brand_code;
        $Brand->product_brand_name = $request->product_brand_name;
        $Brand->status = $request->status;
        $Brand->updated_date = Helper::get_curr_datetime();
        $Brand->updated_by = $user_id;
        $Brand->save();

        $message = 'Product Brand is updated.';
        return redirect('/admin/brand-list')->with('message', $message);
    }

    public function brandListView(){
        $permission = Helper::checkActionPermission('admin', 'brand-list');
        if ($permission === 0) {
            return view('error.301');
        }

        return view('admin/brand/BrandList');
    }

    public function BrandListAjax(Request $request){
        $Products = Brand::select(['id','product_brand_code','product_brand_name','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('product_brand_code')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['product_brand_code'], $request->get('product_brand_code')) ? true : false;
                    });
                }


                if ($request->has('product_brand_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['product_brand_name'], $request->get('product_brand_name')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactbrandStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactbrandStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product_brand');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = Brand::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deletebrand(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deletebrand');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product_brand');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = Brand::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
