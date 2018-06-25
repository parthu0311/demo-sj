<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductVariant;
use App\ProductVariantImage;
use App\SubCategories;
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

use App\GeneralSettings;
use App\ProductGST;
use App\Brand;
use App\Categories;
use App\Questionnaire;
use App\QuestionnaireFieldsValues;
use App\QuestionnaireAnswered;
use App\ProductImages;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminProductDataController extends Controller {
    public $response=array();
    public function __construct() {

    }

    public function ProductManagementCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'product-management-create');
        if ($permission === 0) {
            return view('error.301');
        }
        $brand = Brand::where("status","Active")->get();
        $category = Categories::where("status","Active")->get();
        $ProductGST = ProductGST::where("status","Active")->get();
        $collection = Questionnaire::where("status","Active")->get();
        return view('admin/product/ProductCreate')->with([
            'brand'=>$brand,
            'category'=>$category,
            'ProductGST'=>$ProductGST,
            'collection'=>$collection,
        ]);
    }

    public function productCreatePostData(Request $request){
        $variant = json_decode($request->json_created_variant);


        $this->validate($request, [
            'product_name' => 'required|max:255',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'category_type' => 'required',
            'brand_id' => 'required',
            //'collection_id' => 'required',
            'gst_type_id' => 'required',
            'vendor_price' => 'required',
            'mrp' => 'required',
            'sell_price' => 'required',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Product = new Product();
        $Product->product_name = $request->product_name;
        $Product->category_id = $request->category_id;
        $Product->sub_category_id = $request->sub_category_id;
        $Product->category_type_id = $request->category_type;
        $Product->brand_id = $request->brand_id;
        //$Product->collection_id = $request->collection_id;
        $Product->gst_type_id = $request->gst_type_id;
        $Product->product_description = !empty($request->product_description)?$request->product_description:"";
        $Product->product_code = !empty($request->product_code)?$request->product_code:"";
        $Product->product_slug = str_replace(' ', '-', strtolower($request->product_name));
        $Product->vendor_price = $request->vendor_price;
        $Product->mrp = $request->mrp;
        $Product->sell_price = $request->sell_price;
        $Product->status = $request->status;
        $Product->created_date = Helper::get_curr_datetime();
        $Product->created_by = $user_id;
        $Product->save();
        $all_data = json_decode($request->json_created);
        foreach ($all_data as $key=>$data){
            foreach ($data as $single){
                if($single->value_id != ""){
                    $ProductFields = new QuestionnaireAnswered();
                    $ProductFields->questionnaire_fields_id = $single->field_label_id;
                    $ProductFields->questionnaire_fields_values_id = $single->value_id;
                    $ProductFields->product_id = $Product->id;
                    $ProductFields->save();
                }
            }
        }

        $main_pro_images = json_decode($request->main_pro_images);
        if(!empty($main_pro_images)){
            foreach($main_pro_images as $img){
                $temp = explode('/',$img);
                /*if (copy($source.$temp[count($temp)- 1], $destination.$temp[count($temp)- 1])) {
                    unlink(public_path("uploads/temp_images/" . $temp[count($temp)- 1]));*/
                $ProductImages = new ProductImages();
                $ProductImages->product_id = $Product->id;
                $ProductImages->image_name = $temp[count($temp)- 1];
                $ProductImages->save();
                /*}*/
            }
        }
        $variant = json_decode($request->json_created_variant);
        foreach ($variant as $key_v=>$data_v){
            $ProductVariant = new ProductVariant();
            $ProductVariant->combination = $data_v->combination;
            $ProductVariant->product_id = $Product->id;
            $ProductVariant->sku = $data_v->sku;
            $ProductVariant->price = $data_v->price;
            $ProductVariant->weight = $data_v->weight;
            $ProductVariant->inventory = $data_v->inventory;
            $ProductVariant->status = 'ON';
            $ProductVariant->save();

            $source = public_path("uploads/temp_images/");
            $destination = public_path("uploads/product/");
            if(!empty($data_v->images)){
                foreach(json_decode($data_v->images) as $img){
                    $temp = explode('/',$img);
                    /*if (copy($source.$temp[count($temp)- 1], $destination.$temp[count($temp)- 1])) {
                        unlink(public_path("uploads/temp_images/" . $temp[count($temp)- 1]));*/
                        $ProductVariantImage = new ProductVariantImage();
                        $ProductVariantImage->variant_id = $ProductVariant->id;
                        $ProductVariantImage->product_id = $Product->id;
                        $ProductVariantImage->image = $temp[count($temp)- 1];
                        $ProductVariantImage->save();
                    /*}*/
                }
            }
        }

        $message = 'Product is added.';
        return redirect('/admin/product-management-list')->with('message', $message);
    }

    public function ProductManagementEdit($id){
        $permission = Helper::checkActionPermission('admin', 'product-management-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $product = Product::where("id",$id)->first();
        $brand = Brand::where("status","Active")->get();
        $category = Categories::where("status","Active")->get();
        $subcategory = SubCategories::where("status","Active")->where("parent",0)->get();
        $subcategory_type = SubCategories::where("status","Active")->where("parent",$product->sub_category_id)->get();
        //print_r($subcategory); exit;
        $ProductGST = ProductGST::where("status","Active")->get();
        $collection = Questionnaire::where("status","Active")->get();
        $ProductVariant = ProductVariant::with("Image")->where("product_id",$id)->get();
        $ProductImages = ProductImages::where("product_id",$id)->get();
        //echo '<pre>';print_r($subcategory_type); exit;
        return view('admin/product/ProductEdit')->with([
            'brand'=>$brand,
            'category'=>$category,
            'ProductGST'=>$ProductGST,
            'collection'=>$collection,
            'Product'=>$product,
            'subcategory'=>$subcategory,
            'subcategory_type'=>$subcategory_type,
            'ProductVariant'=>$ProductVariant,
            'ProductImages'=>$ProductImages,
        ]);

    }

    public function ProductManagementEditPost(Request $request,$id){

        $this->validate($request, [
            'product_name' => 'required|max:255',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'category_type_id' => 'required',
            'brand_id' => 'required',
            /*'collection_id' => 'required',*/
            'gst_type_id' => 'required',
            'vendor_price' => 'required',
            'mrp' => 'required',
            'sell_price' => 'required',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $Product = Product::find($request->pro_id);
        $Product->product_name = $request->product_name;
        $Product->category_id = $request->category_id;
        $Product->sub_category_id = $request->sub_category_id;
        $Product->category_type_id = $request->category_type_id;
        $Product->brand_id = $request->brand_id;
        /*$Product->collection_id = $request->collection_id;*/
        $Product->gst_type_id = $request->gst_type_id;
        $Product->product_description = !empty($request->product_description)?$request->product_description:"";
        $Product->product_code = !empty($request->product_code)?$request->product_code:"";
        $Product->product_slug = str_replace(' ', '-', strtolower($request->product_name));;
        $Product->vendor_price = $request->vendor_price;
        $Product->mrp = $request->mrp;
        $Product->sell_price = $request->sell_price;
        $Product->status = $request->status;
        $Product->updated_date = Helper::get_curr_datetime();
        $Product->updated_by = $user_id;
        $Product->save();
        $all_data = json_decode($request->json_created);
        QuestionnaireAnswered::Where('product_id', '=', $request->pro_id)->delete();
        foreach ($all_data as $key=>$data){
            foreach ($data as $single){
                if($single->value_id != ""){
                    $ProductFields = new QuestionnaireAnswered();
                    $ProductFields->questionnaire_fields_id = $single->field_label_id;
                    $ProductFields->questionnaire_fields_values_id = $single->value_id;
                    $ProductFields->product_id = $Product->id;
                    $ProductFields->save();
                }
            }
        }
        $main_pro_images = json_decode($request->main_pro_images);
        if(!empty($main_pro_images)){
            foreach($main_pro_images as $img){
                $temp = explode('/',$img);
                /*if (copy($source.$temp[count($temp)- 1], $destination.$temp[count($temp)- 1])) {
                    unlink(public_path("uploads/temp_images/" . $temp[count($temp)- 1]));*/
                $ProductImages = new ProductImages();
                $ProductImages->product_id = $Product->id;
                $ProductImages->image_name = $temp[count($temp)- 1];
                $ProductImages->save();
                /*}*/
            }
        }
        $variant = json_decode($request->json_created_variant);
        if(count($variant) > 0){
            ProductVariant::Where('product_id', '=', $request->pro_id)->delete();
            foreach ($variant as $key_v=>$data_v){
                $ProductVariant = new ProductVariant();
                $ProductVariant->combination = $data_v->combination;
                $ProductVariant->product_id = $Product->id;
                $ProductVariant->sku = $data_v->sku;
                $ProductVariant->price = $data_v->price;
                $ProductVariant->weight = $data_v->weight;
                $ProductVariant->inventory = $data_v->inventory;
                $ProductVariant->status = "On";
                $ProductVariant->save();

                $source = public_path("uploads/temp_images/");
                $destination = public_path("uploads/product/");
                if(!empty($data_v->images)){
                    foreach(json_decode($data_v->images) as $img){
                        $temp = explode('/',$img);
                        /*if (copy($source.$temp[count($temp)- 1], $destination.$temp[count($temp)- 1])) {
                            unlink(public_path("uploads/temp_images/" . $temp[count($temp)- 1]));*/
                        $ProductVariantImage = new ProductVariantImage();
                        $ProductVariantImage->variant_id = $ProductVariant->id;
                        $ProductVariantImage->product_id = $Product->id;
                        $ProductVariantImage->image = $temp[count($temp)- 1];
                        $ProductVariantImage->save();
                        /*}*/
                    }
                }
            }
        }
        $message = 'Product is Updated.';
        return redirect('/admin/product-management-list')->with('message', $message);

    }

    public function ProductListView(){
        $permission = Helper::checkActionPermission('admin', 'product-management-list');
        if ($permission === 0) {
            return view('error.301');
        }

        return view('admin/product/ProductList');
    }

    public function ProductListAjax(Request $request){

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
                'product.status'])->get();


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

                /*if ($request->has('collection_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['collection_name'], $request->get('collection_name')) ? true : false;
                    });
                }*/

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactProductManagementStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactProductManagementStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = Product::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteProductManagement(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteProductManagement');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'product');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = Product::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    public function get_sub_cat_by_cat(Request $request){
        $categoty_id = $request->categoty_id;
        if(!empty($categoty_id) ){
            $Categories = SubCategories::where("category_id","=",$categoty_id)
                ->where("parent",0)->get();
                //->where("filter_id",'!=',null);
            if(count($Categories) > 0){
                $response['SUCCESS']='TRUE';
                $response['MESSAGE']='';
                $response['Result']=$Categories->toarray();
            }else{
                $response['SUCCESS']='FALSE';
                $response['MESSAGE']='Sub-Category is not available';
            }
        }else{
            $response['SUCCESS']='FALSE';
            $response['MESSAGE']='';
        }
        echo json_encode($response,1);
    }
    public function get_sub_cat_type_by_cat(Request $request){
        $categoty_id = $request->categoty_id;
        if(!empty($categoty_id) ){
            $Categories = SubCategories::where("parent",$request->categoty_id)->get();
                /*where("category_id","=",$categoty_id)*/

            //->where("filter_id",'!=',null);
            if(count($Categories) > 0){
                $response['SUCCESS']='TRUE';
                $response['MESSAGE']='';
                $response['Result']=$Categories->toarray();
            }else{
                $response['SUCCESS']='FALSE';
                $response['MESSAGE']='Category type is not available';
            }
        }else{
            $response['SUCCESS']='FALSE';
            $response['MESSAGE']='';
        }
        echo json_encode($response,1);
    }

    public function get_questionnaire_by_id(Request $request){
        //echo $request->questionnaire_type; exit;
        $Questionnaire = Questionnaire::with('QuesWithFields')->where('id', $request->questionnaire_type)->first();

        $data = [];
        if(isset($Questionnaire->QuesWithFields) && !empty($Questionnaire->QuesWithFields)){
            $data = $Questionnaire->QuesWithFields->toarray();
            foreach ($data as $key=>$fields){
                $values = QuestionnaireFieldsValues::where('questionnaire_fields_id',$fields['id'])->get()->toArray();
                $data[$key]['value'] = $values;
            }
        }
        if(count($data)>0){
            $view = view('admin/product/ProductCreateData',compact('data'))->render();
            return response()->json(['html'=>$view]);
        }else{
            return response()->json(['html'=>""]);
        }

    }

    public function get_questionnaire_by_id_edit(Request $request){
        $Questionnaire = Questionnaire::with('QuesWithFields')->where('id', $request->questionnaire_type)->first();

        $data = [];
        if(isset($Questionnaire->QuesWithFields) && !empty($Questionnaire->QuesWithFields)){
            $data = $Questionnaire->QuesWithFields->toarray();
            $i = 0;
            foreach ($data as $key=>$fields){
                $values = QuestionnaireFieldsValues::where('questionnaire_fields_id',$fields['id'])->get()->toArray();
                $data[$key]['value'] = $values;
                $m = 0;
                foreach($values as $ans_que){
                    $id = !empty($ans_que['id']) ? $ans_que['id'] : 0;
                    $Product_que_ans = QuestionnaireAnswered::where('questionnaire_fields_id',$fields['id'])->where('product_id',$request->pro_id)->where('questionnaire_fields_values_id',$id)->first();
                    if(count($Product_que_ans) > 0){
                        $pro_que_ans_array = $Product_que_ans->toarray();
                        $data[$i]['value'][$m]['Product_que_ans'] = $pro_que_ans_array;
                    }
                    $m++;
                }
                $i++;
            }
        }
        /*echo '<pre>';
        print_r($data);*/
        //$fsdfd = ProductVariant::where('product_id',)
        if(count($data)>0){
            $view = view('admin/product/ProductEditData',compact('data'))->render();
            return response()->json(['html'=>$view]);
        }else{
            return response()->json(['html'=>""]);
        }
    }

    public function ProductImages(Request $request,$id){
        $permission = Helper::checkActionPermission('admin', 'product-images');
        if ($permission === 0) {
            return view('error.301');
        }
        $images = [];
        $ProductImages = ProductImages::where('product_id',$id)->get();
        if(count($ProductImages) >0 ){
            $images = $ProductImages;
        }
        return view('admin/product/ProductImages')->with(['id'=>$id,'image'=>$images]);
    }

    public function productPost(Request $request, $id){
        $picture = '';
        if ($request->file('image')) {
            $files = $request->file('image');
            /*echo '<pre>';
            print_r($files); exit;*/
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').$filename;
                $destinationPath = public_path().'/uploads/product';
                $file->move($destinationPath, $picture);
                DB::table('product_images')->insert(
                    [   'product_id'=>$id,
                        'image_name'=> $picture
                    ]);
            }
        }

        return redirect('/admin/product-images/'.$id);
    }

    public function deleteImage(Request $request){
        if(isset($request->image_id) && !empty($request->image_id)){
            $delete_img = DB::table('product_images')->where('id', '=', $request->image_id)->delete();
            if($delete_img){
                if(file_exists(public_path('uploads/main_product/'.$request->img_name))){
                    unlink(public_path("uploads/main_product/".$request->img_name));
                }
            }
            echo "1"; exit;
        }else{
            echo "0"; exit;
        }

    }
    public function deleteVariant(Request $request){
        if(isset($request->v_id) && !empty($request->v_id)){
            $delete_img = DB::table('product_variant')->where('id', '=', $request->v_id)->delete();
            /*if($delete_img){
                if(file_exists(public_path('uploads/product/'.$request->img_name))){
                    unlink(public_path("uploads/product/".$request->img_name));
                }
            }*/
            echo "1"; exit;
        }else{
            echo "0"; exit;
        }
    }
    public function upload_image_of_product(Request $request){

        if ($request->hasFile('image')) {
            $files = $request->file('image');

            $filename = $files->getClientOriginalName();
            $extension = $files->getClientOriginalExtension();
            $picture = date('His') . $filename;
            $destinationPath = public_path('uploads/product');
            $files->move($destinationPath, $picture);

            if (file_exists(public_path('uploads/product/'.$picture))) {
                $response['code'] = 200;
                $response['url'] = asset("uploads/product/".$picture);
                $response['name'] = $picture;
                $response_json=json_encode($response,true);
            }else{
                $response['code'] = 101;
                $response_json=json_encode($response,true);
            }
        }else{
            $response['code'] = 101;
            $response_json=json_encode($response,true);
        }
        echo $response_json;
    }

    public function upload_image_of_product_base64(Request $request){

        if ($_POST['image']) {

            $croped_image = $_POST['image'];
            list($type, $croped_image) = explode(';', $croped_image);
            list(, $croped_image)      = explode(',', $croped_image);
            $croped_image = base64_decode($croped_image);
            $image_name = time().'.png';
            // upload cropped image to server 
            $destinationPath = public_path('uploads/product');
            file_put_contents($destinationPath.'/'.$image_name, $croped_image);

            
            if (file_exists(public_path('uploads/product/'.$image_name))) {
                $response['code'] = 200;
                $response['url'] = asset("uploads/product/".$image_name);
                $response['name'] = $image_name;
                $response_json=json_encode($response,true);
            }else{
                $response['code'] = 101;
                $response_json=json_encode($response,true);
            }
        }else{
            $response['code'] = 101;
            $response_json=json_encode($response,true);
        }
        echo $response_json;
    }

    public function upload_image_of_product_main(Request $request){

        if ($request->hasFile('image')) {
            $files = $request->file('image');

            $filename = $files->getClientOriginalName();
            $extension = $files->getClientOriginalExtension();
            $picture = date('His') . $filename;
            $destinationPath = public_path('uploads/main_product');
            $files->move($destinationPath, $picture);

            if (file_exists(public_path('uploads/main_product/'.$picture))) {
                $response['code'] = 200;
                $response['url'] = asset("uploads/main_product/".$picture);
                $response['name'] = $picture;
                $response_json=json_encode($response,true);
            }else{
                $response['code'] = 101;
                $response_json=json_encode($response,true);
            }
        }else{
            $response['code'] = 101;
            $response_json=json_encode($response,true);
        }
        echo $response_json;
    }

    public function upload_image_of_product_main_base64(Request $request){

        if ($_POST['image']) {

            $croped_image = $_POST['image'];
            list($type, $croped_image) = explode(';', $croped_image);
            list(, $croped_image)      = explode(',', $croped_image);
            $croped_image = base64_decode($croped_image);
            $image_name = time().'.png';
            // upload cropped image to server 
            $destinationPath = public_path('uploads/main_product');
            file_put_contents($destinationPath.'/'.$image_name, $croped_image);

            /*$files = $request->file('image');

            $filename = $files->getClientOriginalName();
            $extension = $files->getClientOriginalExtension();
            $picture = date('His') . $filename;
            $destinationPath = public_path('uploads/main_product');
            $files->move($destinationPath, $picture);*/

            if (file_exists(public_path('uploads/main_product/'.$image_name))) {
                $response['code'] = 200;
                $response['url'] = asset("uploads/main_product/".$image_name);
                $response['name'] = $image_name;
                $response_json=json_encode($response,true);
            }else{
                $response['code'] = 101;
                $response_json=json_encode($response,true);
            }
        }else{
            $response['code'] = 101;
            $response_json=json_encode($response,true);
        }
        echo $response_json;
    }
}
