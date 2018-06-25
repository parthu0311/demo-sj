<?php

namespace App\Http\Controllers\Front;

use App\AdminUserMaster;

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


class FrontUsersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //  $this->middleware('auth');
        //$this->user = $guard->user();
    }
    
    
    public function index(){

        return view('front.login_registration');
    }
    
   
    public function adminLogin(Request $request) {
        return view('admin/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {

		
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255',
            'mobile' => 'required|max:255',
            'password' => 'required',
            're_password' => 'required'
        ]);

        $users = DB::table('site_users')->insert(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'password' => md5($request->password),
                    'status' => 'Active',
                    'created_date' => Helper::get_curr_datetime(),
                    'updated_date' => Helper::get_curr_datetime()
                ]
        );
        return redirect()->back()->with('message','You are successfully register, Please login using credential');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = md5($request->password);

        if ($request->remember_me == 1) {
            $cookie =  Cookie::queue('email', $email, time() + 31536000);
        } else {
            $cookie =  Cookie::queue('email', '', time() - 100);
        }

        $user = DB::table('site_users')->where('email', $email)->where('password', $password)->first();
        if(!empty($user)){
            $request->session()->put('userDataFront', $user);
            return redirect('/');
        }else{
            return redirect()->back()->with('error','Please enter valid credentials!');
        }


        //return view('admin/editadmiuser', ['user' => $user], ['AdminRole' => $AdminRole]);
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
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
 
}
