<?php

namespace App\Http\Controllers;

use App\Questionnaire;
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
use App\Categories;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller {

    public function __construct() {

    }

    public function productCategoryListView(){
        $permission = Helper::checkActionPermission('admin', 'product-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/product_category/ProductCategoryList');
    }

    public function productCategoryList(Request $request){
        $Products = Categories::select(['id','name','slug','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['name'], $request->get('name')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function productCategoryReOrder(Request $request){
        $permission = Helper::checkActionPermission('admin', 'product-category-reorder');
        if ($permission === 0) {
            return view('error.301');
        }
        $Categories = Categories::orderby('parent_id')->get()->toarray();

        $temp = [];
        foreach ($Categories as $key=>$cat){
            if($cat['parent_id'] == ""){
                $temp['list_'.$cat['id']] = $cat;
            }else{
                $temp['list_'.$cat['parent_id']]['data'][$key] = $cat;
            }
        }
        /*echo '<pre>';
        print_r($temp);exit;*/
        return view('admin/product_category/ProductCategoryReOrder')->with(["Categories"=>$temp]);
    }
    public function CategoryReorderPostData(Request $request){
        if(isset($request->tree) && !empty($request->tree)){
            $data = json_decode($request->tree);
            echo '<pre>';
            print_r($data); exit;
            foreach ($data as $key=>$val){
                if( $key > 0){
                    $Categories = Categories::find($val->id);
                    $Categories->parent_id = $val->parent_id;
                    $Categories->lft = $val->left;
                    $Categories->rgt = $val->right;
                    $Categories->depth = $val->depth;
                    $Categories->save();
                }
            }
            echo "1"; exit;
        }else{
            echo "0"; exit;
        }
    }

    public function ProductCategoryCreate(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'product-category-create');
        if ($permission === 0) {
            return view('error.301');
        }
        //$main_cat = Categories::where('parent_id','=',null)->get();
        return view('admin/product_category/ProductCategoryCreate');
    }

    public function ProductCategoriesCreatePostData(Request $request){

        $this->validate($request, [
            'categories_name' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Categories = new Categories();
        /*$Categories->parent_id = !empty($request->main_cat)?$request->main_cat : null;*/
        $Categories->name = $request->categories_name;
        $Categories->slug = str_replace(' ', '-', strtolower($request->categories_name));
        $Categories->status = $request->status;
        $Categories->save();

        $message = 'Product Categories is added.';
        return redirect('/admin/product-category-list')->with('message', $message);
    }

    public function ProductCategoryEditData($id){
        $permission = Helper::checkActionPermission('admin', 'product-category-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $Categories = Categories::where('id', $id)->first();
        $Questionnaire = Questionnaire::where("status",'Active')->get();
        return view('admin/product_category/ProductCategoryEdit')->with(["Categories"=>$Categories,"Questionnaire"=>$Questionnaire]);
    }

    public function deletProductImage(Request $request){
        if($request->id){
            $delete_img = ImagesMaster::where('id', '=', $request->id)->delete();
            if($delete_img == 1){
                if(file_exists(public_path('uploads/product_images/'.$request->name))){
                    unlink(public_path("uploads/product_images/".$request->name));
                }
                echo '1';
            }else{
                echo '0';
            }
        }
    }

    public function ProductCategoriesEditPostData(Request $request,$id){

        $this->validate($request, [
            'categories_name' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Categories = Categories::find($id);
        /*$Categories->parent_id = !empty($request->main_cat)?$request->main_cat : null;*/
        $Categories->name = $request->categories_name;
        $Categories->status = $request->status;
        $Categories->save();

        $message = 'Product Categories is Updated.';
        return redirect('/admin/product-category-list')->with('message', $message);

    }


    public function activeInactiveProductCategoryStatusData(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactProductCategoryStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'categories');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = Categories::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteProCate(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteProCate');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'categories');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = Categories::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }


}