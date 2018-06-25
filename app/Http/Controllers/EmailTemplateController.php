<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Helper;

class EmailTemplateController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'emailtemplatelist');
        if ($permission === 0) {
            return view('error.301');
        }
        
        return view('emailtemplate/emailtemplatelist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'createemailtemplate');
        if ($permission === 0) {
            return view('error.301');
        }
        
        return view('emailtemplate/addemailtemplate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request   
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'createemailtemplate');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $this->validate($request, [
            'subject' => 'required|max:255',
            'status' => 'required',
            'description' => 'required'
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $page_content = DB::table('email_template')->insert(
                [
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'status' => $request->status,
                    'created_date' => Helper::get_curr_datetime(),
                    'created_by' => $user_id
                ]
        );
        return redirect('admin/emailtemplate/emailtemplatelist');
    }

    public function ajaxemailtemplateList($order_by = "id", $sort_order = "asc", $search = "all", $offset = 0) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'emailtemplatelist');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $aColumns = array('id', 'subject', '', '','status');
        $grid_data = Helper::get_search_data($aColumns);

        $sort_order = $grid_data['sort_order'];
        $order_by = $grid_data['order_by'];
        if ($grid_data['sort_order'] == '' && $grid_data['order_by'] == '') {
            $order_by = 'id';
            $sort_order = 'DESC';
        }

        /*
         * Paging
         */
        $limit = $grid_data['per_page'];
        $offset = $grid_data['offset'];

        $SearchType = $grid_data['SearchType'];
        $search_data = $grid_data['search_data'];

        $data = $this->trim_serach_data($search_data, $SearchType);

        $query = 'select email_template.* from email_template';

        if ($SearchType == 'ORLIKE') {
            $likeStr = Helper::or_like_search($data);
        }
        if ($SearchType == 'ANDLIKE') {
            $likeStr = Helper::and_like_search($data);
        }

        if ($likeStr) {
            $query .= ' Where ' . $likeStr;
        }
        
       // echo $query;die;

        $query .= ' order by ' . $order_by . ' ' . $sort_order;
        $query .= ' limit ' . $limit . ' OFFSET ' . $offset;
        //  echo $query;exit;
        $result = DB::select($query);

        $data = array();
        if (count($result) > 0) {
            $data['result'] = $result;
            $data['totalRecord'] = $this->count_all_email_template_grid($search_data, $SearchType);
        }

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        if (isset($data) && !empty($data)) {
            if (isset($data['result']) && !empty($data['result'])) {
                $output = array(
                    "sEcho" => intval($_GET['sEcho']),
                    "iTotalRecords" => $data['totalRecord'],
                    "iTotalDisplayRecords" => $data['totalRecord'],
                    "aaData" => array()
                );
                foreach ($data['result'] AS $result_row) {
                    $row = array();
                    $row[] = $result_row->id;
                    $row[] = $result_row->subject;
                    $row[] = $result_row->description;
                    $row[] = $result_row->status;
                    $row[] = array();
                    $output['aaData'][] = $row;
                }
            }
        }
        echo json_encode($output);
    }

    /* =============== Start : Trim search function ======================= */

    public function trim_serach_data($search_data, $SearchType) {
        $QueryStr = array();

        if (!empty($search_data)) {
            if ($SearchType == 'ANDLIKE') {
                $i = 0;
                foreach ($search_data as $key => $val) {
                    if ($key == 'subject' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'subject';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = 'LIKE';
                    }
                    if ($key == 'status' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'status';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = '=';
                    }
                    $i++;
                }
            } 
        }
        return $QueryStr;
    }

    // =========== Start :  Count all Record in grid data =========//
    public function count_all_email_template_grid($search_data, $SearchType) {
        $data = $this->trim_serach_data($search_data, $SearchType);

        $query = 'select email_template.* from email_template';

        if ($SearchType == 'ORLIKE') {
            $likeStr = Helper::or_like_search($data);
        }
        if ($SearchType == 'ANDLIKE') {
            $likeStr = Helper::and_like_search($data);
        }

        if ($likeStr) {
            $query .= ' Where ' . $likeStr;
        }

        $result = DB::select($query);
        if (count($result) > 0) {
            return count($result);
        }
        return 0;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'editemailtemplate');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $email_template = DB::table('email_template')->where('id', $id)->first();
        return view('emailtemplate/editemailtemplate', ['email_template' => $email_template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'editemailtemplate');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $this->validate($request, [
            'subject' => 'required|max:255',
            'description' => 'required',
            'status' => 'required'
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;

        $page_content = DB::table('email_template')->where('id', $id)->update([
            'subject' => $request->get('subject'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'updated_date' => Helper::get_curr_datetime(),
            'updated_by' => $user_id
        ]);
        
        return redirect('admin/emailtemplate/emailtemplatelist');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'delete');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $id = $request->id;

        //Code to check if the id from the url exists in the table or not starts here. 
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'email_template');
        if (!$id_exists) {
            return view('error.404');
        }
        //Code to check id ends here

        $del_user = DB::delete('DELETE FROM `email_template` WHERE id IN (' . $id . ')');

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activeInactiveStatus(Request $request) {
        $permission = Helper::checkActionPermission('admin/emailtemplate', 'activeInactiveStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here. 
        //If id does not exists, redirect it to 404 page. 
        $id_exists = Helper::check_id_exists($id, 'email_template');
        if (!$id_exists) {
            return view('error.404');
        }
        //Code to check id ends here

        $Update_status = DB::update('update email_template set status = "' . $status . '" Where id IN (' . $id . ')');

        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

}
