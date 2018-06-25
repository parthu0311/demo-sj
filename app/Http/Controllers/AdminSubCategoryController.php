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
use App\Categories;
use App\SubCategories;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminSubCategoryController extends Controller {

    public function __construct() {

    }



    public function productSubCategoryList(Request $request){

        $SubCategories = SubCategories::
              leftJoin('questionnaire', 'sub_categories.filter_id', '=', 'questionnaire.id')
            ->select(['sub_categories.id','sub_categories.sub_category_name','questionnaire.questionnaire_type','sub_categories.filter_id','sub_categories.status'])
            ->where('sub_categories.parent','!=',0)
            ->where('sub_categories.category_id',$request->get('cat_id'))->get();
        //print_r($SubCategories); exit;
        return Datatables::of($SubCategories)
            ->filter(function ($instance) use ($request) {
                if ($request->has('sub_category_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['sub_category_name'], $request->get('sub_category_name')) ? true : false;
                    });
                }
                if ($request->has('filter_id')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['filter_id'], $request->get('filter_id')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })
            ->make(true);
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

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }


    public function AddSubCategory(Request $request){
        //echo $request->category_id; exit;
        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;
        if(isset($request->sub_category_id) && !empty($request->sub_category_id) ){
            $SubCategories = SubCategories::find($request->sub_category_id);
            $SubCategories->sub_category_name = $request->sub_category_name;
            $SubCategories->sub_category_slug = $this->clean($request->sub_category_name);
            $SubCategories->status = $request->status;
            $result = $SubCategories->save();
        }else{
            $SubCategories = new SubCategories();
            $SubCategories->category_id = $request->category_id;
            $SubCategories->sub_category_name = $request->sub_category_name;
            $SubCategories->sub_category_slug = $this->clean($request->sub_category_name);
            $SubCategories->status = "Active";
            /*$SubCategories->parent = 0;
            $SubCategories->sort = 0;*/
            $result = $SubCategories->save();
        }

        if($result){
            echo "1"; exit;
        }else{
            echo "0"; exit;
        }
    }

    public function ProductCategoryEditData($id){
        $permission = Helper::checkActionPermission('admin', 'product-category-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $Categories = Categories::where('id', $id)->first();
        $main_cat = Categories::where('parent_id','=',null)->get();

        return view('admin/product_category/ProductCategoryEdit')->with(["cat"=>$main_cat,"Categories"=>$Categories]);
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
        $Categories->parent_id = !empty($request->main_cat)?$request->main_cat : null;
        $Categories->name = $request->categories_name;
        $Categories->status = $request->status;
        $Categories->save();

        $message = 'Product Categories is Updated.';
        return redirect('/admin/product-category-list')->with('message', $message);

    }


    public function actInactProductSubCategoryStatus(Request $request){

        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'sub_categories');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = SubCategories::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteProSubCate(Request $request){

        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'sub_categories');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $del_user = SubCategories::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }




    public function change_order_save(Request $request){

        $data = json_decode($_POST['data']);
        $readbleArray = $this->parseJsonArray($data);

        $i=0;
        foreach($readbleArray as $row){
            $i++;
            DB::getPdo()->exec("update sub_categories set parent = '".$row['parentID']."', sort = '".$i."' where id = '".$row['id']."' ");
        }
    }

    public function parseJsonArray($jsonArray, $parentID = 0) {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                /*print_r($subArray); exit;*/
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }
            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }

    public function AddfilterInSubCategory(Request $request){
       if(!empty($request->filter_id) && !empty($request->sub_category_id)){
           $SubCategories = SubCategories::find($request->sub_category_id);
           $SubCategories->filter_id = $request->filter_id;
           $SubCategories->save();

           echo '1';
       } else {
           echo '0';
       }
        exit;


    }

}