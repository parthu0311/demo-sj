<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    /**
     * @param $slug
     */
    public function cart(Request $request){

        $product_details = $_COOKIE['product_details'];

        if(!empty($product_details)){
            $product_details = json_decode($product_details);
            $product_ids = [];
            foreach ($product_details as $key=>$val) {
                array_push($product_ids,$val->product_id);
            }
            $products = \App\Product::select('product.id', 'product.product_name', 'product.product_description', 'product.product_slug', 'product.mrp', 'product.sell_price');
            $products->where('product.status', 'Active');
            $products->whereIn('product.id',$product_ids);
            $products = $products->get();

            if(count($products) > 0 ){
                foreach ($products as $key => $value) {
                    $product_image = $this->productImage($value['id']);
                    if(count($product_image) == 0){
                        $product_image = $this->productVariantImage($value['id']);
                    }
                    $products[$key]['product_image'] = $product_image;

                    $variant = \App\ProductVariant::where('id',$product_details[$key]->product_variant_id)->first();

                    $products[$key]['product_variant'] = $variant->toArray();
                }
                $products->toArray();
            }else{
                $products = [];
            }
        }else{
            $products = [];
        }
//        echo '<pre>';
//        print_r($products->toArray());
//        echo '</pre>';
//        die;

        return view('front.cart')->with(['products'=>$products]);
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
     * @param $product_id
     */
    public function productVariant($product_id)
    {
        return \App\ProductVariant::select('combination', 'id')->where('product_id', $product_id)->get()->toArray();
    }

}