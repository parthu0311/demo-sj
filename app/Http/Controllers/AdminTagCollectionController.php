<?php

namespace App\Http\Controllers;

use App\HomeCollection;
use App\HomeCollectionProduct;
use App\HomeSlider;
use App\HomeTagCollection;
use App\HomeTagCollectionProduct;
use App\Product;
use App\SizeChart;
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

class AdminTagCollectionController extends Controller {

    public function __construct() {

    }

    public function HomeTagCollectionListView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-tag-collection-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeTagCollection/HomeTagCollection');
    }
    public function HomeTagCollectionCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-tag-collection-create');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeTagCollection/HomeTagCollectionCreate');
    }

    public function HomeTagCollectionCreatePostData(Request $request){

        $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        DB::table('home_tag_collection')->insert(
            [   'name'=>$request->name,
                'status'=> $request->status,
            ]);

        $message = 'Home Tag Collection is added.';
        return redirect('/admin/home-tag-collection-list')->with('message', $message);
    }

    public function HomeTagCollectionEdit($id){
        $permission = Helper::checkActionPermission('admin', 'home-tag-collection-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $HomeCollection = HomeTagCollection::where('id', $id)->first();

        return view('admin/HomeTagCollection/HomeTagCollectionEdit', ['HomeCollection' => $HomeCollection]);
    }

    public function HomeTagCollectionEditPost(Request $request,$id){

        $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'required'
        ]);

        DB::table('home_tag_collection')->update(
            [   'name'=>$request->name,
                'status'=> $request->status,
            ]);

        $message = 'Home Tag Collection is Updated.';
        return redirect('/admin/home-tag-collection-list')->with('message', $message);
    }


    public function HomeTagCollectionListAjax(Request $request){
        $Products = HomeTagCollection::select(['id','name','status'])->get();

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

    public function actInactHomeTagCollectionStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactHomeTagCollectionStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_tag_collection');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = HomeTagCollection::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteHomeTagCollection(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteHomeTagCollection');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_tag_collection');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = HomeTagCollection::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    public function HomeTagCollectionProduct($id){
        $permission = Helper::checkActionPermission('admin', 'home-tag-collection-product');
        if ($permission === 0) {
            return view('error.301');
        }
        $HomeCollection = HomeTagCollection::where('id', $id)->first();

        $proids = HomeTagCollectionProduct::where('tag_collection_id',$HomeCollection->id)->get();
        $temp = [];
        if(count($proids)>0){
            foreach ($proids as $id){
                array_push($temp,$id->product_id);
            }
            $pro_ids = implode(',',$temp);
        }else{
            $pro_ids = 0;
        }

        return view('admin/HomeTagCollection/HomeTagCollectionProduct', ['HomeCollection' => $HomeCollection,'pro_ids'=>$pro_ids]);
    }

    public function CollectionChoosableProductListAjax(Request $request){
        $product_ids =  $request->get('product_ids');
        if(empty($product_ids)){
            $product_ids = 0;
        }
        $ids = explode(',',$product_ids);
        /*echo '<pre>';
        print_r($ids); exit;*/
        $Products = Product::
        leftjoin('categories','categories.id', '=','product.category_id')->
        leftjoin('sub_categories','sub_categories.id', '=','product.sub_category_id')->
        leftjoin('product_brand','product_brand.id', '=','product.brand_id')->
        leftjoin('product_gst','product_gst.id', '=','product.gst_type_id')->
        select(
            ['product.id',
                'product.product_name',
                'product.product_code',
                'categories.name as category_name',
                'sub_categories.sub_category_name',
                'product_brand.product_brand_name as brand_name',
                'product_gst.type_name as gst_type',
                'product.vendor_price',
                'product.mrp',
                'product.sell_price',
                'product.product_description',
                'product.status'])
            ->where('product.status','Active')
            ->whereNotIn('product.id', $ids)->get();


        return Datatables::of($Products)
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


                if ($request->has('category_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['category_name'], $request->get('category_name')) ? true : false;
                    });
                }

                if ($request->has('sub_category_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['sub_category_name'], $request->get('sub_category_name')) ? true : false;
                    });
                }

                if ($request->has('brand_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['brand_name'], $request->get('brand_name')) ? true : false;
                    });
                }

                if ($request->has('gst_type')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['gst_type'], $request->get('gst_type')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function add_in_collection(Request $request){
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        $ids = explode(',',$id);
        foreach($ids as $id){
            $HomeTagCollectionProduct = new HomeTagCollectionProduct();
            $HomeTagCollectionProduct->tag_collection_id = $request->collection_id;
            $HomeTagCollectionProduct->product_id = $id;
            $HomeTagCollectionProduct->status = 'Active';
            $HomeTagCollectionProduct->save();
        }

            $proids = HomeTagCollectionProduct::where('tag_collection_id',$request->collection_id)->get();
            $temp = [];
            if(count($proids)>0){
                foreach ($proids as $id){
                    array_push($temp,$id->product_id);
                }
                $pro_ids = implode(',',$temp);
            }else{
                $pro_ids = 0;
            }
            echo $pro_ids;

        exit;
    }

    public function TagCollectionProductListAjax(Request $request){
        $product_ids =  $request->get('product_ids');
        if(empty($product_ids)){
            $product_ids = 0;
        }
        $ids = explode(',',$product_ids);
        /*echo '<pre>';
        print_r($ids); exit;*/
        $Products = HomeTagCollectionProduct::
        leftjoin('product','product.id', '=','home_tag_collection_product.product_id')->
        leftjoin('categories','categories.id', '=','product.category_id')->
        leftjoin('sub_categories','sub_categories.id', '=','product.sub_category_id')->
        leftjoin('product_brand','product_brand.id', '=','product.brand_id')->
        leftjoin('product_gst','product_gst.id', '=','product.gst_type_id')->
        select(
            ['home_tag_collection_product.id',
                'product.product_name',
                'product.product_code',
                'categories.name as category_name',
                'sub_categories.sub_category_name',
                'product_brand.product_brand_name as brand_name',
                'product_gst.type_name as gst_type',
                'product.vendor_price',
                'product.mrp',
                'product.sell_price',
                'product.product_description',
                'home_tag_collection_product.status'])
            ->where('tag_collection_id',$request->collection_id)->get();


        return Datatables::of($Products)
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


                if ($request->has('category_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['category_name'], $request->get('category_name')) ? true : false;
                    });
                }

                if ($request->has('sub_category_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['sub_category_name'], $request->get('sub_category_name')) ? true : false;
                    });
                }

                if ($request->has('brand_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['brand_name'], $request->get('brand_name')) ? true : false;
                    });
                }

                if ($request->has('gst_type')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['gst_type'], $request->get('gst_type')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function removeProductFromCollection(Request $request){

        $id = $request->id;

        $ids = explode(',',$id);
        $del_user = HomeTagCollectionProduct::whereIn('id', $ids)->delete();

        $proids = HomeTagCollectionProduct::where('tag_collection_id',$request->collection_id)->get();
        $temp = [];
        if(count($proids) > 0 ){
            foreach ($proids as $id){
                array_push($temp,$id->product_id);
            }
            $pro_ids = implode(',',$temp);
        }else{
            $pro_ids = 0;
        }
        echo $pro_ids;
        exit;
    }

    public function actInactProductCollectionStatus(Request $request){

        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_tag_collection_product');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = HomeTagCollectionProduct::whereIn('id', $ids)->update(['status' => $status]);

        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

}
