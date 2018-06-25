<?php

namespace App\Http\Controllers;

use App\HomeSlider;
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

class AdminHomeSliderController extends Controller {

    public function __construct() {

    }

    public function HomeSliderListView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-slider-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeSlider/homeslider');
    }
    public function HomeSliderCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'home-slider-create');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/HomeSlider/HomeSliderCreate');
    }

    public function HomeSliderCreatePostData(Request $request){

        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required',
            'status' => 'required',
            'image_banner' => 'required',
        ]);

        if ($request->file('image_banner')) {
            $file = $request->file('image_banner');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His').$filename;
            $destinationPath = public_path().'/uploads/banner_image';
            $file->move($destinationPath, $picture);
            DB::table('home_slider')->insert(
                [   'name'=>$request->name,
                    'image'=> $picture,
                    'url'=> $request->url,
                    'status'=> $request->status,
                ]);

        }

        $message = 'Home Slider is added.';
        return redirect('/admin/home-slider-list')->with('message', $message);
    }

    public function HomeSliderEdit($id){
        $permission = Helper::checkActionPermission('admin', 'home-slider-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $HomeSlider = HomeSlider::where('id', $id)->first();

        return view('admin/HomeSlider/HomeSliderEdit', ['HomeSlider' => $HomeSlider]);
    }

    public function HomeSliderEditPost(Request $request,$id){

        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required',
            'status' => 'required',
            'image_banner' => 'required',
        ]);


        if ($request->file('image_banner')) {
            unlink(public_path("uploads/banner_image/".$request->old_img));
            $file = $request->file('image_banner');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His').$filename;
            $destinationPath = public_path().'/uploads/banner_image';
            $file->move($destinationPath, $picture);
            DB::table('home_slider')->update(
                [   'name'=>$request->name,
                    'image'=> $picture,
                    'url'=> $request->url,
                    'status'=> $request->status,
                ]);
        }else{
            DB::table('home_slider')->update(
                [   'name'=>$request->name,
                    'url'=> $request->url,
                    'status'=> $request->status,
                ]);
        }

        $message = 'Home Slider is added.';
        return redirect('/admin/home-slider-list')->with('message', $message);
    }


    public function HomeSliderListAjax(Request $request){
        $Products = HomeSlider::select(['id','name','image','url','status'])->get();

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

    public function actInactSliderStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactSliderStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_slider');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = HomeSlider::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteHomeSlider(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteHomeSlider');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'home_slider');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = HomeSlider::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
