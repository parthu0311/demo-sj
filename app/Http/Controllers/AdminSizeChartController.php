<?php

namespace App\Http\Controllers;

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

class AdminSizeChartController extends Controller {

    public function __construct() {

    }

    public function SizeChartListView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'size-chart-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/size_chart/size_chart');
    }
    public function SizeChartCreateView(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'size-chart-create');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/size_chart/SizeChartCreate');
    }

    public function SizeChartCreatePostData(Request $request){

        $this->validate($request, [
            'size_chart_for' => 'required|max:255',
            'data' => 'required',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $SizeChart = new SizeChart();
        $SizeChart->size_chart_for = $request->size_chart_for;
        $SizeChart->data = $request->data;
        $SizeChart->status = $request->status;
        $SizeChart->save();

        $message = 'Size Chart is added.';
        return redirect('/admin/size-chart-list')->with('message', $message);
    }

    public function SizeChartEdit($id){
        $permission = Helper::checkActionPermission('admin', 'size-chart-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $SizeChart = SizeChart::where('id', $id)->first();

        return view('admin/size_chart/size_chartEdit', ['SizeChart' => $SizeChart]);
    }

    public function SizeChartEditPost(Request $request,$id){

        $this->validate($request, [
            'size_chart_for' => 'required|max:255',
            'data' => 'required',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $SizeChart = SizeChart::find($id);
        $SizeChart->size_chart_for = $request->size_chart_for;
        $SizeChart->data = $request->data;
        $SizeChart->status = $request->status;
        $SizeChart->save();

        $message = 'Size Chart is updated.';
        return redirect('/admin/size-chart-list')->with('message', $message);
    }


    public function SizeChartListAjax(Request $request){
        $Products = SizeChart::select(['id','size_chart_for','data','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('size_chart_for')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['size_chart_for'], $request->get('size_chart_for')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function actInactSizeChartStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'actInactSizeChartStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'size_chart');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = SizeChart::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteSizeChart(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deleteSizeChart');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'size_chart');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = SizeChart::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
