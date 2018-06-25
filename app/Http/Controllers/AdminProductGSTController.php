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
use App\ProductGST;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminProductGSTController extends Controller {

    public function __construct() {

    }

    public function GSTManagementCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'gst-management-create');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/GSTManagement/GSTCreate');
    }

    public function GSTManagementCreatePostData(Request $request){

        $this->validate($request, [
            'type_name' => 'required|max:255',
            'code' => 'required|max:255',
            'percentage' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $ProductGST = new ProductGST();
        $ProductGST->type_name = $request->type_name;
        $ProductGST->code = $request->code;
        $ProductGST->percentage = $request->percentage;
        $ProductGST->status = $request->status;
        $ProductGST->created_date = Helper::get_curr_datetime();
        $ProductGST->created_by = $user_id;
        $ProductGST->save();

        $message = 'Product GST Type is added.';
        return redirect('/admin/gst-management-list')->with('message', $message);
    }

    public function GSTManagementEdit($id){
        $permission = Helper::checkActionPermission('admin', 'gst-management-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $ProductGST = ProductGST::where('id', $id)->first();

        return view('admin/GSTManagement/GSTEdit', ['ProductGST' => $ProductGST]);
    }

    public function GSTManagementEditPost(Request $request,$id){

        $this->validate($request, [
            'type_name' => 'required|max:255',
            'code' => 'required|max:255',
            'percentage' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $ProductGST = ProductGST::find($id);
        $ProductGST->type_name = $request->type_name;
        $ProductGST->code = $request->code;
        $ProductGST->percentage = $request->percentage;
        $ProductGST->status = $request->status;
        $ProductGST->updated_date = Helper::get_curr_datetime();
        $ProductGST->updated_by = $user_id;
        $ProductGST->save();

        $message = 'GST Management is updated.';
        return redirect('/admin/gst-management-list')->with('message', $message);
    }

    public function GSTManagemntListView(){
        $permission = Helper::checkActionPermission('admin', 'gst-management-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/GSTManagement/GSTList');
    }

    public function GSTManagemntListAjax(Request $request){
        $Products = ProductGST::select(['id','type_name','code','percentage','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('type_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['type_name'], $request->get('type_name')) ? true : false;
                    });
                }

                if ($request->has('code')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['code'], $request->get('code')) ? true : false;
                    });
                }


                if ($request->has('percentage')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['percentage'], $request->get('percentage')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactGSTManagementStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactGSTManagementStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product_gst');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = ProductGST::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteGSTManagement(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteGSTManagement');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product_gst');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = ProductGST::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
