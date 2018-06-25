<?php

namespace App\Http\Controllers;

use App\AdminUserMaster;
use App\InternalUserMaster;
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

use Adminuser;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Adil\Shyplite\Shyplite;

class AdminController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //  $this->middleware('auth');
        //$this->user = $guard->user();
    }

    public function set_order() {

        $congis = [
            'username'=> 'suriljain3@gmail.com',
            'password' => 'suril@1234',
            'app_id' => '1025', // Your app's ID
            'seller_id' => '5231',   // Your seller ID
            'key' => 'Iixl5EYzs7U='
        ];

        $shyplite = new Shyplite($congis); // Constructor takes config array as argument
        $response = $shyplite->login();
        $shyplite->setToken($response->userToken);

        print_r($shyplite); exit;

        $email =  "suriljain3@gmail.com";
        $password =  "suril@1234";

        $timestamp = time();
        $appID = 1025;
        $key = 'Iixl5EYzs7U=';
        $secret = 'PJqnnEpWbvfUAoVn9yv4sgdfgsdfgdfgdfrrmQoFdSXiDlnCSOUHKFLNm46sEUoZC6G88ouxDl2Ql2gZ2w==';

        $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        $ch = curl_init();

        $header = array(
            "x-appid: $appID",
            "x-timestamp: $timestamp",
            "Authorization: $authtoken"
        );

        curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailID=$email&password=$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        var_dump($server_output);
        exit;
        curl_close($ch);


        $timestamp = time();
        $appID = 1025;
        $key = 'Iixl5EYzs7U=';
        $secret = '6957287570f402721dca1d297basdfawr434sdf365905eee9bd5e13b538339865a1e6e12';

        $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        $ch = curl_init();

        $data = array( 'orders'=> [
            array(
                "orderId"=> "TSTAPI038",
                "customerName"=> "Pushpendra Kumar",
                "customerAddress"=> "B-56, M-Block Lane No. 56 Kakadeo Near City Model School",
                "customerCity"=> "Kanpur",
                "customerPinCode"=> "208019",
                "customerContact"=> "1111111111",
                "orderDate"=> "2017-07-25",
                "modeType"=> "Air",
                "orderType"=> "prepaid",
                "totalValue"=> "1708.50",
                "categoryName"=> "Cameras Audio and Video",
                "packageName"=> "Sony Extra-bass Headphone.",
                "quantity"=> "1",
                "packageLength"=> "5.50",
                "packageWidth"=> "10",
                "packageHeight"=> "1.0",
                "packageWeight"=> "0.5",
                "sellerAddressId"=> "4209"
            )
        ]);

        $data_json = json_encode($data);

        $header = array(
            "x-appid: $appID",
            "x-sellerid:5231",
            "x-timestamp: $timestamp",
            "Authorization: $authtoken",
            "Content-Type: application/json",
            "Content-Length: ".strlen($data_json)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/order');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        var_dump($response);
        exit;
        curl_close($ch);

    }
    
    public function index(){
        $permission = Helper::checkActionPermission('admin', 'dashboard');
        if ($permission === 0) {
            return view('error.301');
        } 
        return view('admin/dashboard');
    }
    
   
    public function adminLogin(Request $request) {
        return view('admin/login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request) {
        $email = $request->email;
        $password = md5($request->password);
		
        if ($request->remember_me == 1) {
            $cookie =  Cookie::queue('username', $email, time() + 31536000);
        } else {
            $cookie =  Cookie::queue('username', '', time() - 100);
        }

        $user = DB::table('tbl_adminuser')->where('email_address', $email)->where('password', $password)->first();

        $request->session()->put('userData', $user);
        
        if(count($user) > 0){
          $userPrivileges =  DB::table('user_privileges')->where('role_id', $user->role_id)->first();
          $request->session()->put('userPrivilegesData', $userPrivileges); 
        }
        

       
        if (count($user) > 0) {
            $role_master =  DB::table('role_master')->where('role_id', $user->role_id)->first();
            $request->session()->put('roleMasterData', $role_master);
            return redirect('admin/dashboard');
        } else {
            return redirect('/admin/login')->with('message', 'Your email and password isnot correct.');
        }

        /* if (Auth::attempt(['email' => $email, 'password' => $password])) {
          return view('admin/formcontrol');
          }else{
          return redirect('admin')->with('message', 'Your email and password isnot correct.');

          } */
    }

    public function forgotpassword(Request $request) {
         /* $permission = Helper::checkActionPermission('admin', 'resetpassword');
          if ($permission === 0) {
          return view('error.301');
          } */

        $email = $request->email;

        //$user = DB::table('tbl_adminuser')->where('email_address', $email)->first();
        $user = AdminUserMaster::where([ ['email_address', $email] ])->first();
        $userID = $user->id;

        if (count($user) > 0) {

            $token = sha1(uniqid(rand(), true) . 'Fu+uR3l1fE5EcuR!+y!');

           /* DB::table('tbl_adminuser')
                    ->where('id', $user->id)
                    ->update(['remember_token' => $token]);*/

             AdminUserMaster::where('id', $user->id)
                            ->update(['remember_token' => $token]);

            //$user_token = DB::table('tbl_adminuser')->select('remember_token')->where('id', $user->id)->first();
            $user_token = AdminUserMaster::select('remember_token')->where([ ['id', $user->id] ])->first();
            $final_token = $user_token->remember_token;
            $message = 'Send mail to set reset password Link.';

            //=== Mail Send Functionality
            Mail::send('admin.emails.resetpassword', ['userID' => $final_token, 'users' => $user, 'message' => $message], function ($message) use ($user) {
                $message->from('troodeveloper@gmail.com', 'Reset Password Link.');
                //$message->to('mayuri.patel@trootech.com')->subject('Reset Password Link.');
                $message->to($user->email_address)->subject('Reset Password Link.');
            });
            return redirect('admin')->with('success', 'Mail Send Successfully.Please Check mail.');
            //return view('admin/resetpasswordpage');
        } else {
            return redirect('admin')->with('message', 'Your email isnot correct.');
        }
    }

	public function resetpasswordpage(Request $request) {
        $token = $request->token;
        $user = DB::table('tbl_adminuser')->where('remember_token', $token)->first();

        return view('admin/resetpasswordpage', ['user' => $user]);
    }

    public function changepassword(Request $request) {
        /* $permission = Helper::checkActionPermission('admin', 'changepassword');
          if ($permission === 0) {
          return view('error.301');
          } */
        $token = $request->check_token;
        $password = md5($request->password);

        AdminUserMaster::where('remember_token', $token)
                        ->update(['password' => $password]);

        $updated_id = AdminUserMaster::where('remember_token', $token)->first();;

        AdminUserMaster::where('id', $updated_id->id)
                ->update(['remember_token' => '']);

        // return view('admin/login');
        return redirect('admin')->with('success', 'Your password change successfully.');
    }
        
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showInternalUsers()
    {
        $permission = Helper::checkActionPermission('admin', 'internalusers');
        if ($permission === 0) {
            return view('error.301');
        }
       // $AdminuserList = DB::table('tbl_adminuser')->get();
     //   $InternaluserList = InternalUserMaster::where('role_id','!=','0')->get();
       // print_r($AdminuserList);die;
        $Adminrole = DB::table('role_master')->get();
        return view('admin/internaluserList',['adminroleList' => $Adminrole]);
    }

    public function show() {
        $permission = Helper::checkActionPermission('admin', 'internalusers');
        if ($permission === 0) {
            return view('error.301');
        }
    //    $AdminuserList = DB::table('tbl_adminuser')->get();
        $Adminrole = DB::table('role_master')->get();
      //  return view('admin/adminuserList', ['adminUserList' => $AdminuserList,'adminroleList' => $Adminrole]);
        return view('admin/adminuserList', ['adminroleList' => $Adminrole]);
    }

    public function test(Request $request){
        //$users = AdminUserMaster::select(['id', 'first_name','status','role_id'])->with('roll')->get();
        $users = AdminUserMaster::join('role_master', 'tbl_adminuser.role_id', '=', 'role_master.role_id')
            ->select(['tbl_adminuser.id','tbl_adminuser.first_name','tbl_adminuser.email_address','tbl_adminuser.status', 'role_master.role_name','tbl_adminuser.role_id'])->get();
        return Datatables::of($users)

     //   print_r($users);die;
            ->editColumn('role_name', function ($user) {
                return ucwords(str_replace('_',' ',$user->role_name));
            })
           /* ->addColumn('action', function ($user) {
                return '<a href="editadminUser/'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
<a href="#edit-'.$user->id.'"  onclick="deleterecord('.$user->id.') class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove-circle"></i></a>';
            })*/
            ->filter(function ($instance) use ($request) {

                if ($request->has('first_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['first_name'], $request->get('first_name')) ? true : false;
                    });
                }

                if ($request->has('email_address')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['email_address'], $request->get('email_address')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }

                if ($request->has('role_name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['role_id'], $request->get('role_name')) ? true : false;
                    });
                }
            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permission = Helper::checkActionPermission('admin', 'createAdminUser');
        if ($permission === 0) {
           return view('error.301');
        }

        $AdminRole = DB::table('role_master')->where('status', '=', 'Active')->get(); // To Get Record For Dynamic Dropdown role 
        $view_data['AdminRole'] = $AdminRole;

        return view('admin/createadmiuser', ['AdminRole' => $AdminRole]);
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'create');
        if ($permission === 0) {
            return view('error.301');
        }
		
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email_address' => 'required|max:255',
            'password' => 'required|max:255',
            'role_id' => 'required',
            'status' => 'required'
        ]);

        $users = DB::table('tbl_adminuser')->insert(
                [
                    'first_name' => $request->firstname,
                    'last_name' => $request->last_name,
                    'email_address' => $request->email_address,
                    'password' => md5($request->password),
                    'status' => $request->status,
                    'role_id' => $request->role_id,
                    'createdDate' => Helper::get_curr_datetime(),
                    'updatedDate' => Helper::get_curr_datetime()
                ]
        );
        return redirect('admin/adminusers');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $permission = Helper::checkActionPermission('admin', 'editadminUser');
        if ($permission === 0) {
            return view('error.301');
        }

        $user = DB::table('tbl_adminuser')->where('id', $id)->first();
		$AdminRole = DB::table('role_master')->where('status', '=', 'Active')->get(); // To Get Record For Dynamic Dropdown role
        $view_data['AdminRole'] = $AdminRole;

        return view('admin/editadmiuser', ['user' => $user], ['AdminRole' => $AdminRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminreate\Http\Response
     */
    public function update(Request $request, $id) {
        $permission = Helper::checkActionPermission('admin', 'update');
        if ($permission === 0) {
            return view('error.301');
        }
		
	$this->validate($request, [
            'firstname' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email_address' => 'required|max:255',
            'role_id' => 'required',
            'status' => 'required'
        ]);

        $users = AdminUserMaster::where('id', $id)->update(['first_name' => $request->get('firstname'),
            'last_name' => $request->get('last_name'),
            'email_address' => $request->get('email_address'),
            'role_id' => $request->get('role_id'),
            'status' => $request->get('status'),
            'updatedDate' => Helper::get_curr_datetime()]);
        return redirect('admin/adminusers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'delete');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here. 
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'tbl_adminuser');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = AdminUserMaster::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    public function adminAjaxList($order_by = "id", $sort_order = "asc", $search = "all", $offset = 0) {
        $permission = Helper::checkActionPermission('admin', 'adminAjaxList');
        if ($permission === 0) {
            return view('error.301');
        }
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */

        $aColumns = array('id', 'first_name', 'email_address', 'status', 'role_name');
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

        $query = 'select tbl_adminuser.*, role_master.role_name as name from tbl_adminuser Left Join role_master ON tbl_adminuser.role_id = role_master.role_id';

        if ($SearchType == 'ORLIKE') {
            $likeStr = Helper::or_like_search($data);
        }
        if ($SearchType == 'ANDLIKE') {
            $likeStr = Helper::and_like_search($data);
        }

        if ($likeStr) {
            $query .= ' Where ' . $likeStr;
        }

        $query .= ' order by ' . $order_by . ' ' . $sort_order;
        $query .= ' limit ' . $limit . ' OFFSET ' . $offset;

        $result = DB::select($query);


        $data = array();
        if (count($result) > 0) {
            $data['result'] = $result;
            $data['totalRecord'] = $this->count_all_customer_grid($search_data, $SearchType);
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
                    $row[] = $result_row->first_name;
                    $row[] = $result_row->email_address;
                    $row[] = $result_row->status;
                    $row[] = $result_row->name;
                    $row[] = array();
                    $output['aaData'][] = $row;
                }
            }
        }
        //print_r(json_encode($output));exit;
        echo json_encode($output);
    }

    /* =============== Start : Trim search function ======================= */

      public function trim_serach_data($search_data, $SearchType) {
        $QueryStr = array();

        if (!empty($search_data)) {
            if ($SearchType == 'ANDLIKE') {
                $i = 0;
                foreach ($search_data as $key => $val) {
                    if ($key == 'first_name' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'first_name';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = 'LIKE';
                    }
                    if ($key == 'email_address' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'email_address';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = 'LIKE';
                    }
                    if ($key == 'role_name' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'role_master.role_name';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = 'LIKE';
                    }
                    if ($key == 'status' && !empty($val)) {
                        $QueryStr[$i]['Field'] = 'tbl_adminuser.status';
                        $QueryStr[$i]['Value'] = $val;
                        $QueryStr[$i]['Operator'] = '=';
                    }


                    $i++;
                }
            } else {
                !empty($search_data['first_name']) ? $QueryStr['first_name'] = $search_data['first_name'] : "";
                !empty($search_data['email_address']) ? $QueryStr['email_address'] = $search_data['email_address'] : "";
                !empty($search_data['role_name']) ? $QueryStr['role_name'] = $search_data['role_name'] : "";
                !empty($search_data['status']) ? $QueryStr['tbl_adminuser.status'] = $search_data['status'] : "";
            }
        }
        return $QueryStr;
    }

    // =========== Start :  Count all Record in grid data =========//
    public function count_all_customer_grid($search_data, $SearchType) {
        $data = $this->trim_serach_data($search_data, $SearchType);

        $query = 'select tbl_adminuser.*, role_master.role_name as name from tbl_adminuser Left Join role_master ON tbl_adminuser.role_id = role_master.role_id ';

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activeInactiveStatus(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'activeInactiveStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here. 
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'tbl_adminuser');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
       // $Update_status = DB::update('update tbl_adminuser set status = "' . $status . '" Where id IN (' . $id . ')');
        $Update_status = AdminUserMaster::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function editProfile(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'editProfile');
        if ($permission === 0) {
            return view('error.301');
        }
       // $id = 1;
        $UserId = $request->session()->get('userData');
        $id = $UserId->id;
        $user = DB::table('tbl_adminuser')->where('id', $id)->first();
        return view('admin/editProfile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminreate\Http\Response
     */
    public function updateProfile(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'updateProfile');
        if ($permission === 0) {
            return view('error.301');
        }
        //$id = 1;
        $UserId = $request->session()->get('userData');
        $id = $UserId->id;
        $users = DB::table('tbl_adminuser')->where('id', $id)->update([
            'first_name' => $request->get('firstname'),
            'last_name' => $request->get('last_name'),
            'email_address' => $request->get('email_address'),
            'status' => $request->get('status'),
            'updatedDate' => Helper::get_curr_datetime()
        ]);
        return redirect('admin/viewProfile');
    }

    public function viewProfile(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'viewProfile');
        if ($permission === 0) {
            return view('error.301');
        }
        //$id = 1;
        $UserId = $request->session()->get('userData');
        $id = $UserId->id;
        $user = DB::table('tbl_adminuser')->where('id', $id)->first();
        return view('admin/viewProfile', ['user' => $user]);
    }

    public function profilechangePassword() {
        $permission = Helper::checkActionPermission('admin', 'profilechangePassword');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/profilechangePassword');
    }

    public function changepwdProfile(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'changepwdProfile');
        if ($permission === 0) {
            return view('error.301');
        }
       // $id = 1;
        $UserId = $request->session()->get('userData');
        $id = $UserId->id;
        $old_password = md5($request->old_password);
        $new_password = md5($request->new_password);

        $checkExistPwd = DB::table('tbl_adminuser')->where('password', $old_password)->first();


        if (count($checkExistPwd) > 0) {

            $Password = $checkExistPwd->password;

            if ($old_password == $Password) {
                $user = DB::table('tbl_adminuser')
                        ->where('id', $checkExistPwd->id)
                        ->update(['password' => $new_password]);

                // return view('admin/login');
                return redirect('admin/viewProfile')->with('success', 'Your password change successfully.');
            } else {
                return redirect('admin/viewProfile')->with('message', 'Your Password Does not match. Please Try Again');
            }
        } else {
            return redirect('admin/viewProfile')->with('message', 'Your Password Does not match. Please Try Again');
        }
    }

    public function logout(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'logout');
        if ($permission === 0) {
            return view('error.301');
        }
       // $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('admin');
    }
 
}
