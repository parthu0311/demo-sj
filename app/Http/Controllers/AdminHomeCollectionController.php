<?php

namespace App\Http\Controllers;

use App\HomeCollection;
use App\HomeCollectionProduct;
use App\HomeSlider;
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

class AdminHomeCollectionController extends Controller {

    public function __construct() {

    }

    public function HomeCollectionListView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-collection-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeCollection/HomeCollection');
    }
    public function HomeCollectionCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-collection-create');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeCollection/HomeCollectionCreate');
    }

    public function HomeCollectionCreatePostData(Request $request){

        $this->validate($request, [
            'collection_for' => 'required|max:255',
            'collection_summery' => 'required',
            'status' => 'required',
            'image_banner' => 'required',
        ]);

        if ($request->file('image_banner')) {
            $file = $request->file('image_banner');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His').$filename;
            $destinationPath = public_path().'/uploads/collection_image';
            $file->move($destinationPath, $picture);
            DB::table('home_collection')->insert(
                [   'collection_slug'=> Helper::slug_generator($request->collection_for.' '.$request->collection_summery),
                    'collection_for'=>$request->collection_for,
                    'collection_summery'=>$request->collection_summery,
                    'image'=> $picture,
                    'status'=> $request->status,
                ]);

        }

        $message = 'Home Collection is added.';
        return redirect('/admin/home-collection-list')->with('message', $message);
    }

    public function HomeCollectionEdit($id){
        $permission = Helper::checkActionPermission('admin', 'home-collection-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $HomeCollection = HomeCollection::where('id', $id)->first();

        return view('admin/HomeCollection/HomeCollectionEdit', ['HomeCollection' => $HomeCollection]);
    }

    public function HomeCollectionEditPost(Request $request,$id){

        $this->validate($request, [
            'collection_for' => 'required|max:255',
            'collection_summery' => 'required',
            'status' => 'required'
        ]);


        if ($request->file('image_banner')) {
            unlink(public_path("uploads/collection_image/".$request->old_img));
            $file = $request->file('image_banner');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His').$filename;
            $destinationPath = public_path().'/uploads/collection_image';
            $file->move($destinationPath, $picture);
            DB::table('home_collection')->update(
                [   'collection_for'=>$request->collection_for,
                    'collection_summery'=>$request->collection_summery,
                    'image'=> $picture,
                    'status'=> $request->status,
                ]);
        }else{
            DB::table('home_collection')->update(
                [   'collection_for'=>$request->collection_for,
                    'collection_summery'=> $request->collection_summery,
                    'status'=> $request->status,
                ]);
        }

        $message = 'Home Slider is Updated.';
        return redirect('/admin/home-collection-list')->with('message', $message);
    }


    public function HomeCollectionListAjax(Request $request){
        $Products = HomeCollection::select(['id','collection_for','collection_summery','image','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('collection_for')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['collection_for'], $request->get('collection_for')) ? true : false;
                    });
                }
                if ($request->has('collection_summery	')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['collection_summery	'], $request->get('collection_summery	')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactHomeCollectionStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactHomeCollectionStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_collection');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = HomeCollection::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteHomeCollection(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteHomeCollection');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_collection');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = HomeCollection::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    public function HomeCollectionProduct($id){
        $permission = Helper::checkActionPermission('admin', 'home-collection-product');
        if ($permission === 0) {
            return view('error.301');
        }
        $HomeCollection = HomeCollection::where('id', $id)->first();

        $proids = HomeCollectionProduct::where('collection_id',$HomeCollection->id)->get();
        $temp = [];
        if(count($proids)>0){
            foreach ($proids as $id){
                array_push($temp,$id->product_id);
            }
            $pro_ids = implode(',',$temp);
        }else{
            $pro_ids = 0;
        }

        return view('admin/HomeCollection/HomeCollectionProduct', ['HomeCollection' => $HomeCollection,'pro_ids'=>$pro_ids]);
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
            $HomeCollectionProduct = new HomeCollectionProduct();
            $HomeCollectionProduct->collection_id = $request->collection_id;
            $HomeCollectionProduct->product_id = $id;
            $HomeCollectionProduct->status = 'Active';
            $HomeCollectionProduct->save();
        }

            $proids = HomeCollectionProduct::where('collection_id',$request->collection_id)->get();
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

    public function CollectionProductListAjax(Request $request){
        $product_ids =  $request->get('product_ids');
        if(empty($product_ids)){
            $product_ids = 0;
        }
        $ids = explode(',',$product_ids);
        /*echo '<pre>';
        print_r($ids); exit;*/
        $Products = HomeCollectionProduct::
        leftjoin('product','product.id', '=','home_collection_product.product_id')->
        leftjoin('categories','categories.id', '=','product.category_id')->
        leftjoin('sub_categories','sub_categories.id', '=','product.sub_category_id')->
        leftjoin('product_brand','product_brand.id', '=','product.brand_id')->
        leftjoin('product_gst','product_gst.id', '=','product.gst_type_id')->
        select(
            ['home_collection_product.id',
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
                'home_collection_product.status'])
            ->where('collection_id',$request->collection_id)->get();


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
        $del_user = HomeCollectionProduct::whereIn('id', $ids)->delete();

        $proids = HomeCollectionProduct::where('collection_id',$request->collection_id)->get();
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
        $id_exists = Helper::check_id_exists($id, 'home_collection_product');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = HomeCollectionProduct::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

}
