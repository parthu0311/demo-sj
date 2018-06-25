<?php

namespace App\Http\Controllers;

use App\HomeCollection;
use App\HomeCollectionProduct;
use App\HomeSlider;
use App\HomeTagCollection;
use App\HomeTagCollectionProduct;
use App\OfferZoneCollection;
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

class AdminOfferZoneCollectionController extends Controller {

    public function __construct() {

    }


    public function HomeTagCollectionProduct(Request $request){
        $permission = Helper::checkActionPermission('admin', 'offer-collection-product');
        if ($permission === 0) {
            return view('error.301');
        }
        $proids = OfferZoneCollection::get();
        $temp = [];
        if(count($proids)>0){
            foreach ($proids as $id){
                array_push($temp,$id->product_id);
            }
            $pro_ids = implode(',',$temp);
        }else{
            $pro_ids = 0;
        }

        return view('admin/OfferZoneCollection/OfferZoneCollectionProduct', ['pro_ids'=>$pro_ids]);
    }


    public function add_in_offer_collection(Request $request){
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        $ids = explode(',',$id);
        foreach($ids as $id){
            $OfferZoneCollection = new OfferZoneCollection();
            $OfferZoneCollection->product_id = $id;
            $OfferZoneCollection->status = 'Active';
            $OfferZoneCollection->save();
        }

            $proids = OfferZoneCollection::get();
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

    public function offerCollectionProductListAjax(Request $request){
        $product_ids =  $request->get('product_ids');
        if(empty($product_ids)){
            $product_ids = 0;
        }
        $ids = explode(',',$product_ids);
        /*echo '<pre>';
        print_r($ids); exit;*/
        $Products = OfferZoneCollection::
        leftjoin('product','product.id', '=','offer_zone_collection.product_id')->
        leftjoin('categories','categories.id', '=','product.category_id')->
        leftjoin('sub_categories','sub_categories.id', '=','product.sub_category_id')->
        leftjoin('product_brand','product_brand.id', '=','product.brand_id')->
        leftjoin('product_gst','product_gst.id', '=','product.gst_type_id')->
        select(
            ['offer_zone_collection.id',
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
                'offer_zone_collection.status'])->get();


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

    public function removeProductFromOfferCollection(Request $request){

        $id = $request->id;

        $ids = explode(',',$id);
        $del_user = OfferZoneCollection::whereIn('id', $ids)->delete();

        $proids = OfferZoneCollection::get();
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

    public function actInactProductOfferCollectionStatus(Request $request){

        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'offer_zone_collection');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = OfferZoneCollection::whereIn('id', $ids)->update(['status' => $status]);

        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

}
