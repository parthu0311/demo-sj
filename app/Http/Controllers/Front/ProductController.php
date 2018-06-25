<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * @param $slug
     */
    public function productDetail(Request $request, $slug)
    {
        $input = $request->all();
        $slugcheck = $this->slugcheck($slug);
        if ($slugcheck == false) {
            return redirect('/');
        }
        if (isset($input['size']) && $input['size'] != null && !is_numeric($input['size'])) {
            return redirect('/');
        }
        $product = $this->getProduct($slug, $input);
        return view('front.product.product-detail', compact('product'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productFilter(Request $request)
    {
        $getFilters = $this->filterGet();
        $priceFilter = $this->priceFilterQuery();
        return view('front.product.product-filter', compact('getFilters', 'priceFilter'));
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getProduct($slug, $input = array(),Request $request)
    {
        /*echo '<pre>';
        print_r($_GET[rawurldecode('Ideal%2520For')]);
        exit;*/
        $sub_category_id = \App\SubCategories::select('id','filter_id')
                            ->where('sub_category_slug', $slug)
                            ->first();

       if(isset($sub_category_id->id) && !empty($sub_category_id->id)){


            $filter_data = \App\QuestionnaireFields::with('questionnaire_fields_values')
                            ->where('questionnaire_id', $sub_category_id->filter_id)
                            ->where('is_show_filter', 'Yes')
                            ->get()
                            ->toArray();
            /*echo '<pre>';
            print_r($filter_data); exit; */               
            //DB::enableQueryLog();
            $products = \App\Product::select('product.id', 'product.product_name', 'product.product_description', 'product.product_slug', 'product.mrp', 'product.sell_price');
            //$products->join('questionnaire_answered', 'questionnaire_answered.product_id', '=', 'product.id');
            $products->where('product.category_type_id', $sub_category_id->id);
            $products->where('product.status', 'Active');
            
            if(isset($_GET['price']) && !empty($_GET['price']) ){
                $price_url = explode(',', $_GET['price']);
                $products->whereBetween('product.sell_price', array((int)$price_url[0], (int)$price_url[1]));
                
            }
            
            foreach ($filter_data as $key => $value) {
                        if(isset($_GET[rawurlencode(str_replace(' ', '-',$value['field_label']))])
                            && 
                            !empty($_GET[rawurlencode(str_replace(' ', '-',$value['field_label']))]) ){
                            $val =  $_GET[rawurlencode(str_replace(' ', '-',$value['field_label']))];

                            $QuesFieldsVal = \App\QuestionnaireFieldsValues::
                                select(DB::raw('group_concat(id) as fields_id'))
                                    ->where('questionnaire_id', $sub_category_id->filter_id)
                                    ->whereIn('value', explode(',', $val))
                                    ->get();

                            $QuesFieldsVal2 = \App\QuestionnaireAnswered::
                                select(DB::raw('group_concat(product_id) as ids'))
                                ->whereIn('questionnaire_fields_values_id', explode(',', $QuesFieldsVal[0]->fields_id))
                                ->get();
                            if(count($QuesFieldsVal2) > 0){
                                $products->whereIn('product.id', explode(',', $QuesFieldsVal2[0]->ids));
                            } 
                        }
                    } 
            
            $products = $products->paginate(15);

             /*$query = DB::getQueryLog();
             dd($query);*/
            //$products = $products->toArray();
            
            if(count($products) > 0){
                foreach ($products as $key => $value) {
                    $product_image = $this->productImage($value['id']);
                    if(count($product_image) == 0){
                        $product_image = $this->productVariantImage($value['id']);
                    }
                    $products[$key]['product_image'] = $product_image;  


                    $product_variant = $this->productVariant($value['id']);
                    $products[$key]['product_variant'] = $product_variant; 
                }
            }

            /*echo '<pre>';
            print_r($products->toArray()); exit;*/

            $new_arr_input = [];
            /*foreach ($filter_data as $key => $value) {
                $new_arr_input["'".$value['field_label']."'"] =  'Input::get('."'".$value['field_label']."'".')';
            }  */  
            $priceFilter = $this->priceFilterQuery();
            $priceFilter2 = $this->variantpriceFilterQuery();
             if($priceFilter2['minPrice'] < $priceFilter['minPrice'] && $priceFilter2['minPrice'] != 0){
                $priceFilter['minPrice'] = $priceFilter2['minPrice'];
            }                           
                     
       }
        
        /*echo "<pre>";
        print_r($priceFilter2); die;*/
        
        return view('front.product.product-filter', compact('products', 'filter_data','priceFilter','new_arr_input'));
    }


    public function getProductCategory($slug, Request $request)
    {
        $sub_category_id = \App\SubCategories::where('sub_category_slug', $slug)
                            ->first();

       if(isset($sub_category_id->id) && !empty($sub_category_id->id)){

            $sub_categories = \App\SubCategories::
                              where('parent', $sub_category_id->id)
                            ->get();

            $Brand_Ids = \App\Product::
                                select('brand_id')
                                    ->where('sub_category_id', $sub_category_id->id)
                                    ->groupBy('brand_id','id')
                                    ->get();                
            $Brand_Ids_arr = [];
            foreach ($Brand_Ids as $key => $value) {
                if (!in_array($value->brand_id, $Brand_Ids_arr)){
                        array_push($Brand_Ids_arr, $value->brand_id);
                  }
            }
            $Brands = \App\Brand::whereIn('id', $Brand_Ids_arr)->get();          
            /*echo '<pre>';
            print_r($Brands); exit;*/                
            //DB::enableQueryLog();
            $products = \App\Product::select('product.id', 'product.product_name', 'product.product_description', 'product.product_slug', 'product.mrp', 'product.sell_price');
            //$products->join('questionnaire_answered', 'questionnaire_answered.product_id', '=', 'product.id');
            $products->where('product.sub_category_id', $sub_category_id->id);
            $products->where('product.status', 'Active');

             if(isset($_GET[rawurlencode('sub-category')])
                            && 
                            !empty($_GET[rawurlencode('sub-category')]) ){
                            $val =  explode(',', $_GET[rawurlencode('sub-category')]);

                            $temp_arr_ids = [];
                           
                            foreach ($sub_categories as $key => $value) {
                                 if (in_array($value['sub_category_slug'], $val)){
                                        array_push($temp_arr_ids, $value['id']);
                                    }
                            }
                            /*echo '<pre>';
                                print_r($temp_arr_ids); exit; */
                            if(count($temp_arr_ids) > 0){
                                $products->whereIn('category_type_id', $temp_arr_ids);
                            }
                    
                }
                if(isset($_GET[rawurlencode('brand')])
                            && 
                            !empty($_GET[rawurlencode('brand')]) ){
                            $val_brand =  explode(',', $_GET[rawurlencode('brand')]);
                            $products->whereIn('brand_id', $val_brand);
                    }
            
            if(isset($_GET['price']) && !empty($_GET['price']) ){
                $price_url = explode(',', $_GET['price']);
                $products->whereBetween('product.sell_price', array((int)$price_url[0], (int)$price_url[1]));
                
            }
            
            
            
            $products = $products->paginate(15);

             /*$query = DB::getQueryLog();
             dd($query);*/
            //$products = $products->toArray();
            
            if(count($products) > 0){
                foreach ($products as $key => $value) {
                    $product_image = $this->productImage($value['id']);
                    if(count($product_image) == 0){
                        $product_image = $this->productVariantImage($value['id']);
                    }
                    $products[$key]['product_image'] = $product_image;  


                    $product_variant = $this->productVariant($value['id']);
                    $products[$key]['product_variant'] = $product_variant; 
                }
            }

            /*echo '<pre>';
            print_r($products->toArray()); exit;*/

            $new_arr_input = [];
            /*foreach ($filter_data as $key => $value) {
                $new_arr_input["'".$value['field_label']."'"] =  'Input::get('."'".$value['field_label']."'".')';
            }  */  
            $priceFilter = $this->priceFilterQuery();
            $priceFilter2 = $this->variantpriceFilterQuery();
            if($priceFilter2['minPrice'] < $priceFilter['minPrice'] && $priceFilter2['minPrice'] != 0){
                $priceFilter['minPrice'] = $priceFilter2['minPrice'];
            }                           
                     
       }
       $filter_data = [];
        
        /*echo "<pre>";
        print_r($priceFilter); die;*/
        
        return view('front.product.product-filter-category', compact('products', 'sub_categories','Brands',
            'priceFilter','new_arr_input'));
    }

    public function productDetails($slug, Request $request)
    {
        $products = \App\Product::with('Image')
                        ->where('product_slug',$slug)->first();

        if(!empty($products)){
        
            if(isset($_GET['search']) && !empty($_GET['search']) ){
                $get_data = explode('-', $_GET['search']);

                $variant_data = \App\ProductVariant::with('Image')
                        ->where('product_id',$products->id)
                        ->get();
                foreach ($variant_data as $key => $value) {
                         $preg_rep = preg_replace('/\s+/', '',$value->combination);
                          $get_data_check = implode('|', $get_data);
                            if($preg_rep == $get_data_check){
                                $variant = $value;
                            }
                        }        
                /*echo '<pre>';
                print_r(); exit;*/        
            }else {
                $variant = \App\ProductVariant::with('Image')
                        ->where('product_id',$products->id)->first();
            }
            
            if(!empty($variant)){
                $products->variant = $variant->toArray(); 
            }else {
                $products->variant = [];  
            }

            $sub_category_id = \App\SubCategories::select('id','filter_id')
                            ->where('id', $products->category_type_id)
                            ->first();
            $filter_data = \App\QuestionnaireFields::with('questionnaire_fields_values')
                            ->where('questionnaire_id', $sub_category_id->filter_id)
                            ->where('is_show_tooltip','=', 'Yes')
                            ->get();            
            if(!empty($filter_data)){
                $products->filter_data = $filter_data->toArray(); 
            }else {
                $products->filter_data = [];  
            }


            /* Related Product Section*/
            $prod= \App\Product::select('product.id', 'product.product_name', 'product.product_slug', 'product.mrp', 'product.sell_price');
            $prod->where('product.id','!=', $products->id);
            $prod->where('product.status', 'Active');
            $prod = $prod->paginate(15);

            if(count($prod) > 0){
                foreach ($prod as $key => $value) {
                    $product_image = $this->productImage($value->id);
                    if(count($product_image) == 0){
                        $product_image = $this->productVariantImage($value->id);
                    }
                    $prod[$key]->product_image = $product_image;  
                }
            }
            $prod = $prod->toArray();
            /*echo '<pre>';    
            print_r($prod); exit;*/

        }                
        /*echo '<pre>';
        print_r($products->toArray()); die;*/
        return view('front.product.product-detail',compact('products','prod'));
    }

    public function productCollection($slug, Request $request){
        $productCollection = \App\HomeCollection::with('home_collection_product')->where('collection_slug',$slug)->first();

        echo '<pre>';
        print_r($productCollection);
        echo '</pre>';
        exit;


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
     * @param $slug
     * @return mixed
     */
    public function slugcheck($slug)
    {
        return \App\Product::where('product_slug', $slug)->where('status', 'Active')->exists();
    }

    /**
     * @param $product_id
     */
    public function productVariant($product_id)
    {
        return \App\ProductVariant::select('combination', 'id')->where('product_id', $product_id)->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function filterGet()
    {
        $getQuestionnariFileds = \App\QuestionnaireFields::select('field_label', 'id')->where('is_show_filter', 'Yes')->where('is_show_tooltip', 'Yes')->get()->toArray();
        foreach ($getQuestionnariFileds as $getQuestionnariFiledKey => $getQuestionnariFiled) {
            $getQuestionnariFileds[$getQuestionnariFiledKey]['filterKey'] = \App\QuestionnaireFieldsValues::select('questionnaire_fields_values.value', 'questionnaire_fields_values.id')->get()->toArray();
        }
        //select('questionnaire_fields_values.value','questionnaire_fields_values.id')->join('questionnaire_fields_values','questionnaire_fields_values.questionnaire_fields_id','=','questionnaire_fields.id')
        return $getQuestionnariFileds;
    }

    /**
     * @return array
     */
    public function priceFilterQuery()
    {
        return \App\Product::select(DB::raw("MAX(sell_price) as maxPrice"), DB::raw("Min(sell_price) as minPrice"))->first();
    }
    public function variantpriceFilterQuery()
    {
        return \App\ProductVariant::select(DB::raw("MAX(price) as maxPrice"), DB::raw("Min(price) as minPrice"))->first();
    }
}