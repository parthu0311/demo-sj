<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Input;
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

/**
 * Class HomeController
 * @package App\Http\Controllers\Front
 */
class HomeController extends Controller
{

    /**
     * @param Request $request
     */
    public function home(Request $request)
    {
        $homeSliders = $this->homePageSlider();
        $homeCollectionSliders = $this->homeCollectionSlider();
        $homeCollectionTags = $this->homeCollectionTag();
        //$homeCollectionTagProduct = $this->homeCollectionTagProduct();
        if (count($homeCollectionTags) > 0) {
            foreach ($homeCollectionTags as $key => $value) {
                $Tags_product = \App\HomeTagCollectionProduct::
                                select(DB::raw('group_concat(product_id) as ids'))
                                ->where('tag_collection_id',$value->id)->first();
                 if(!empty($Tags_product->ids)){
                   $product_by_ids = \App\Product::select('product.id', 'product.product_name', 'product.product_slug', 'product.mrp', 'product.sell_price')
                                ->where('status', 'Active')
                                ->whereIn('product.id', explode(',', $Tags_product->ids))
                                ->get()->toArray();
                    if(count($product_by_ids) > 0){
                        foreach ($product_by_ids as $key1 => $value1) {
                            $product_image = $this->productImage($value1['id']);
                            if(count($product_image) == 0){
                                $product_image = $this->productVariantImage($value1['id']);
                            }
                            $product_by_ids[$key1]['product_image'] = $product_image;  
                        }
                    }            
                    $value->product =  $product_by_ids;
                 }else {
                    $value->product = [];
                 }                                      
            }
           
            $BestSelling = \App\Product::select('product.id', 'product.product_name', 'product.product_slug', 'product.mrp', 'product.sell_price')
                                ->where('status', 'Active')
                                ->offset(0)->limit(10)
                                ->get()->toArray();
                    if(count($BestSelling) > 0){
                        foreach ($BestSelling as $key1 => $value1) {
                            $product_image = $this->productImage($value1['id']);
                            if(count($product_image) == 0){
                                $product_image = $this->productVariantImage($value1['id']);
                            }
                            $BestSelling[$key1]['product_image'] = $product_image;  
                        }
                    }
          /*echo '<pre>';
            print_r($BestSelling); exit;*/
        }
        $homeCollectionTagProduct = [];
        return view('front.home.index', compact('homeSliders', 'homeCollectionSliders', 'homeCollectionTags','homeCollectionTagProduct','BestSelling'));
    }

    /**
     * @return mixed
     */
    public function homePageSlider()
    {
        return \App\HomeSlider::select('id', 'name', 'image', 'url')->where('status', 'Active')->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function homeCollectionSlider()
    {
        return \App\HomeCollection::select('collection_slug','collection_for', 'collection_summery', 'image')->where('status', 'Active')->limit(4)->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function homeCollectionTag()
    {
        return \App\HomeTagCollection::select('name', 'id')->where('status', 'active')->get();
    }

    /**
     * @param $productId
     * @return mixed
     */
    private function productImage($productId)
    {
        return \App\ProductImages::select('id', 'image_name')->where('product_id', $productId)->offset(0)->limit(2)->get()->toArray();
    }

    /**
     * @param $productId
     * @return mixed
     */
    private function productVariantImage($productId)
    {
        return \App\ProductVariantImage::select('id', 'image as image_name','product_id')->where('product_id', $productId)->offset(0)->limit(2)->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function homeCollectionTagProduct()
    {
        $getTagCollectionProducts = \App\HomeTagCollection::select('name', 'id')->where('status', 'Active')->get()->toArray();
        foreach ($getTagCollectionProducts as $getCollaProKey => $getCollaProValue) {
            $getTagCollectionProducts[$getCollaProKey]['product'] = \App\HomeTagCollectionProduct::select('product.id', 'product.product_name', 'product.product_slug', 'product.mrp', 'product.sell_price','product_images.image_name as productImage')
                ->where('tag_collection_id',$getCollaProValue['id'])
                ->leftjoin('product','product.id','=','home_tag_collection_product.product_id')
                ->leftjoin('product_images','product_images.product_id','=','product.id')
                ->groupBy('product.id')
                ->orderBy('product.id')
                ->get()->toArray();
  //          $getTagCollectionProducts[$getCollaProKey]['product'] = \App\Product::select('id', 'product_name', 'product_slug', 'mrp', 'sell_price')->where('status', 'Active')->get()->toArray();
        }
        return $getTagCollectionProducts;
    }


}
