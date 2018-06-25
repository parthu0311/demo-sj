<?php

namespace App\Http\Controllers;

use App\Categories;
use App\HomeCollection;
use App\HomeCollectionProduct;
use App\HomeSlider;
use App\HomeTagCollection;
use App\HomeTagCollectionProduct;
use App\Offer;
use App\OfferZoneCollection;
use App\Product;
use App\SizeChart;
use App\SubCategories;
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

class AdminOfferCollectionController extends Controller {

    public function __construct() {

    }


    public function OfferCreationView(Request $request){
        $permission = Helper::checkActionPermission('admin', 'offer-creation');
        if ($permission === 0) {
            return view('error.301');
        }
        /*$Categories = Categories::where('status','Active')->get();
        $SubCategories = SubCategories::where('parent','!=',0)->where('status','Active')->get();
        $Brand = Brand::where('status','Active')->get();
        $Product = Product::where('status','Active')->get();*/
        return view('admin/Offer/Offer');
    }
    public function get_Offer_creation(Request $request){
        if($request->get('type') == "FLAT_DISCOUNT"){
            $view = view('admin/Offer/OfferDiscountRs')->render();
            return response()->json(['html'=>$view]);
        }else if($request->get('type') == "PERCENT_DISCOUNT"){
            $view = view('admin/Offer/OfferDiscountPercent')->render();
            return response()->json(['html'=>$view]);
        }else if($request->get('type') == "FREE_SHIPPING"){
            $view = view('admin/Offer/OfferDiscountShipping')->render();
            return response()->json(['html'=>$view]);
        }else if($request->get('type') == "SALE_PRICE"){
            $view = view('admin/Offer/OfferDiscountSalePrice')->render();
            return response()->json(['html'=>$view]);
        }
    }

    public function get_Offer_edit(Request $request){
        $Offer = Offer::where('id',$request->id)->first();
        if($request->type_of_coupon == "FLAT_DISCOUNT"){
            $view = view('admin/Offer/OfferDiscountRsEdit')->with(['Offer'=>$Offer])->render();
            return response()->json(['html'=>$view]);
        }else if($request->type_of_coupon == "PERCENT_DISCOUNT"){
            $view = view('admin/Offer/OfferDiscountPercentEdit')->with(['Offer'=>$Offer])->render();
            return response()->json(['html'=>$view]);
        }else if($request->type_of_coupon == "FREE_SHIPPING"){
            $view = view('admin/Offer/OfferDiscountShippingEdit')->with(['Offer'=>$Offer])->render();
            return response()->json(['html'=>$view]);
        }else if($request->type_of_coupon == "SALE_PRICE"){
            $view = view('admin/Offer/OfferDiscountSellEdit')->with(['Offer'=>$Offer])->render();
            return response()->json(['html'=>$view]);
        }
    }

    public function CreateOfferPost(Request $request){

            if(!empty($request->offer_id)){
                $Offer = Offer::find($request->offer_id);
                $Offer->type_of_coupon = $request->type_of_coupon;
                $Offer->coupon_code = $request->coupon_code;
                $Offer->coupon_name = $request->coupon_name;
                $Offer->discount = isset($request->discount)?$request->discount:null;
                $Offer->apply_to = $request->apply_to;
                $Offer->product_id = isset($request->product)?implode(',',$request->product):null;
                $Offer->category_id = isset($request->categories)?$request->categories:null;
                $Offer->category_type_id = isset($request->sub_category_type)?$request->sub_category_type:null;
                $Offer->brand_id = isset($request->brand)?$request->brand:null;
                $Offer->home_collection_id = isset($request->specific_collection)?$request->specific_collection:null;
                $Offer->minimum_subtotal = isset($request->minimum_subtotal)?$request->minimum_subtotal:null;
                $Offer->valid_from = date('Y-m-d H:i:s',strtotime($request->valid_from));
                $Offer->valid_to = isset($request->valid_to)?date('Y-m-d H:i:s',strtotime($request->valid_to)):null;
                $Offer->valid_unlimited = !empty($request->valid_unlimited)?"Yes":"No";
                $Offer->limit_uses = !empty($request->limit_uses)?$request->limit_uses:null;
                $Offer->limit_uses_unlimited = !empty($request->limit_uses_unlimited)?"Yes":"No";
                $Offer->status = "Active";
                $Offer->save();
            }else{
                $Offer = new Offer();
                $Offer->type_of_coupon = $request->type_of_coupon;
                $Offer->coupon_code = $request->coupon_code;
                $Offer->coupon_name = $request->coupon_name;
                $Offer->discount = isset($request->discount)?$request->discount:null;
                $Offer->apply_to = $request->apply_to;
                $Offer->product_id = isset($request->product)?implode(',',$request->product):null;
                $Offer->category_id = isset($request->categories)?$request->categories:null;
                $Offer->category_type_id = isset($request->sub_category_type)?$request->sub_category_type:null;
                $Offer->brand_id = isset($request->brand)?$request->brand:null;
                $Offer->home_collection_id = isset($request->specific_collection)?$request->specific_collection:null;
                $Offer->minimum_subtotal = isset($request->minimum_subtotal)?$request->minimum_subtotal:null;
                $Offer->valid_from = date('Y-m-d H:i:s',strtotime($request->valid_from));
                $Offer->valid_to = isset($request->valid_to)?date('Y-m-d H:i:s',strtotime($request->valid_to)):null;
                $Offer->valid_unlimited = !empty($request->valid_unlimited)?"Yes":"No";
                $Offer->limit_uses = !empty($request->limit_uses)?$request->limit_uses:null;
                $Offer->limit_uses_unlimited = !empty($request->limit_uses_unlimited)?"Yes":"No";
                $Offer->status = "Active";
                $Offer->save();
            }


        $message = 'Offer is created.';
        return redirect('/admin/offer-creation')->with('message', $message);
    }

    public function OfferListAjax(Request $request){
        $Products = Offer::
        leftjoin('categories','categories.id', '=','offer.category_id')->
        leftjoin('sub_categories','sub_categories.id', '=','offer.category_type_id')->
        leftjoin('product_brand','product_brand.id', '=','offer.brand_id')->
                        select([
                            'offer.id',
                            'offer.type_of_coupon',
                            'offer.coupon_code',
                            'offer.coupon_name',
                            'offer.discount',
                            'offer.apply_to',
                            'offer.product_id as product_name',
                            'categories.name as category_name',
                            'sub_categories.sub_category_name',
                            'product_brand.product_brand_name',
                            'offer.minimum_subtotal',
                            'offer.valid_from',
                            'offer.valid_to',
                            'offer.valid_unlimited',
                            'offer.limit_uses',
                            'offer.limit_uses_unlimited',
                            'offer.status'
                         ])->get();

        foreach ($Products as $single){
            $pr = Product::select(DB::raw('GROUP_CONCAT(product_name SEPARATOR ", ") as product_name'))->whereIn('id',explode(',',$single['product_name']))->first();
            $single['product_name'] = $pr['product_name'];
        }
        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('type_of_coupon')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['type_of_coupon'], $request->get('type_of_coupon')) ? true : false;
                    });
                }

                if ($request->has('coupon_code')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['coupon_code'], $request->get('coupon_code')) ? true : false;
                    });
                }


                if ($request->has('coupon_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['coupon_name'], $request->get('coupon_name')) ? true : false;
                    });
                }
                if ($request->has('apply_to')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['apply_to'], $request->get('apply_to')) ? true : false;
                    });
                }
                if ($request->has('valid_unlimited')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['valid_unlimited'], $request->get('valid_unlimited')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactOfferStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactOfferStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'offer');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = Offer::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteOffer(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteOffer');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'offer');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = Offer::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
