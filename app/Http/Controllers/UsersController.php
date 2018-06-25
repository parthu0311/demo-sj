<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\User;
use App\Libraries\MCrypt;
use Illuminate\Support\Facades\Hash;
use Mail;

class UsersController extends Controller {

    public function encrypt(Request $request) {
        $mcrypt = new MCrypt();
        $q = $request->key;
        $email = $mcrypt->encrypt($q);
        return( $email );
    }

    public function decrypt(Request $request) {
        $mcrypt = new MCrypt();
        $q = $request->key;
        $email = $mcrypt->decrypt($q);
        return( $email );
    }

    /**
     * Request Parameter : [email, password, Apikey]
     * Request Api Url : "/api/login"
     * Request Controller & Method : UserController/login
     * Success response : [ message : success,  code : 200,  data : User details Array]
     * Error response : 
      1) [message : Your account is Inactive, Please contact Site Admin..,  code : 101]
      2)[ message : Your email-id or password is invalid. , code : 101]
      3)[ message : Unauthorised Call. , code : 101]
     * Method  : POST
     */
    public function login(Request $request) {

        $mcrypt = new MCrypt();

        $Apikey = $request->Apikey;
        if ($Apikey == APIKEY) {
            $password = $mcrypt->decrypt($request->password);
            if (!empty($request->email)) {
                $email = $mcrypt->decrypt($request->email);
                
                $query1 = DB::table('users')->where('email', $email)->where('password', $password)->where('status', 'Active')->first();
                if (!is_null($query1)) {
                    $user = $query1;
                    if ($user->status == 'Inactive') {
                        $msg = 'Your account is Inactive, Please contact Site Admin..';
                        $code = 101;
                        return response()->json(['message' => $msg, 'code' => $code]);
                    } else if (count($user) > 0) {
                        $msg = 'success';
                        $code = 200;
                        return response()->json(['message' => $msg, 'code' => $code, 'data' => $user]);
                    }
                } else {
                    $msg = 'Your Email or password is invalid.';
                    $code = 101;
                    return response()->json(['message' => $msg, 'code' => $code]);
                }
            }

            if (!empty($request->username)) {
                $username = $mcrypt->decrypt($request->username);

                $query = DB::table('users')->where('username', $username)->where('password', $password)->where('status', 'Active')->first();
                if (!is_null($query)) {
                    $user = $query;
                    if ($user->status == 'Inactive') {
                        $msg = 'Your account is Inactive, Please contact Site Admin..';
                        $code = 101;
                        return response()->json(['message' => $msg, 'code' => $code]);
                    } else if (count($user) > 0) {
                        $msg = 'success';
                        $code = 200;
                        return response()->json(['message' => $msg, 'code' => $code, 'data' => $user]);
                    }
                } else {
                    $msg = 'Your Username or password is invalid.';
                    $code = 101;
                    return response()->json(['message' => $msg, 'code' => $code]);
                }
            }
            //$email = $this->decrypt($request->email);
            //$password = $this->decrypt($request->password);
            // print_r($password);exit;
            /* if (Auth::attempt(['email' => $email, 'password' => $password])) {
              echo 'mayuri here';exit;
              return view('admin/formcontrol');
              }else{
              echo 'mayuri here111';exit;
              return redirect('admin')->with('message', 'Your email and password isnot correct.');
              } */
        } else {
            return response()->json(['message' => 'Unauthorised Call', 'code' => 101]);
        }
    }

    /*
     * Request Parameter :  [Apikey, name, email, password,dateofbirth, latitude, longitude, gender, username]
     * Method : POST
     * Request Api Url : "/api/signup"
     * Request Controller & Method : UserController/signup
     * Success response : [ message : User save SuccessFully.,  code : 200]
     * Error response : 
      1)[ message : Unauthorised Call. , code : 101]
      2)[ message : User Already Exists, code : 101]
     */

    public function signup(Request $request) {
        $mcrypt = new MCrypt();
        $Apikey = $request->Apikey;

        if ($Apikey == APIKEY) {
            $name = $mcrypt->decrypt($request->name);
            $username = $mcrypt->decrypt($request->username);
            $email = $mcrypt->decrypt($request->email);
            $password = $mcrypt->decrypt($request->password);
            $dateofbirth = $mcrypt->decrypt($request->dateofbirth);
            $latitude = $mcrypt->decrypt($request->latitude);
            $longitude = $mcrypt->decrypt($request->longitude);
            $gender = $mcrypt->decrypt($request->gender);

            $count = DB::table('users')->where('email', '=', $email)->count();
            if ($count > 0) {
                return response()->json(['message' => 'User Already Exists', 'code' => 101]);
            } else {
                $users = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    //  'password' => Hash::make($password),
                    'status' => 'Inactive',
                    'date_of_birth' => date('Y-m-d', strtotime($dateofbirth)),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'gender' => $gender,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $users_details = DB::table('users')->where('id', $users)->first();
                $userID = $mcrypt->encrypt($users_details->id);
                $message = 'User save SuccessFully.';

                //=== Mail Send Functionality
                Mail::send('emails.signup', ['userID'=> $userID,'user' => $users_details, 'message' => $message], function ($message) use ($users_details) {
                    $message->from('troodeveloper@gmail.com', 'User Activation Mail.');
                    //$message->to('mayuri.patel@trootech.com')->subject('Register User Activatation Mail');
                    $message->to($users_details->email)->subject('Register User Activatation Mail');
                });


                $msg = 'User save SuccessFully.Check Email For Verification Link.';
                $code = 200;
                return response()->json(['message' => $msg, 'code' => $code]);
            }
        } else {
            return response()->json(['message' => 'Unauthorised Call', 'code' => 101]);
        }
    }

    /*
     * For Activation Link This Method Call
     */

    public function activateAccount(Request $request) {
       // $id = $request->id;
        $mcrypt = new MCrypt();
        $id = $mcrypt->decrypt($request->id);
        $users = DB::table('users')->where('id', $id)->update([
            'status' => 'Active',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($users) {
            $msg = 'Your Account Activation Successfully.';
            echo $msg;
            die;
        } else {
            $msg = 'Your Account Activation Failed.';
            echo $msg;
            die;
        }
       
    }

    /*
     * Request Parameter :  [Apikey, email]
     * Method : POST
     * Request Api Url : "/api/forgotPassword"
     * Request Controller & Method : UsersController/forgotPassword
     * Success response : [ message : Mail Send Successfully. Please Check Your email.',  code : 200]
     * Error response : 
      1)[ message : Unauthorised Call. , code : 101]
      2)[ message : Email Address does not Match., code : 101]
     */

    public function forgotPassword(Request $request) {
        $mcrypt = new MCrypt();
        $Apikey = $request->Apikey;

        if ($Apikey == APIKEY) {
            $email = $mcrypt->decrypt($request->email);
            $users = DB::table('users')->where('email', '=', $email)->first();
            $userID = $mcrypt->encrypt($users->id);
            if (count($users) > 0) {
                $message = 'Send mail to set reset password Link.';

                //=== Mail Send Functionality
                Mail::send('emails.resetpassword', ['userID' => $userID, 'users' => $users, 'message' => $message], function ($message) use ($users) {
                    $message->from('troodeveloper@gmail.com', 'Reset Password Link.');
                    //$message->to('mayuri.patel@trootech.com')->subject('Reset Password Link.');
                    $message->to($users->email)->subject('Reset Password Link.');
                });

                return response()->json(['message' => 'Mail Send Successfully. Please Check Your email', 'code' => 200]);
            } else {
                return response()->json(['message' => 'Email Address does not Match.', 'code' => 101]);
            }
        } else {
            return response()->json(['message' => 'Unauthorised Call', 'code' => 101]);
        }
    }

    public function resetPassword($id) {
        $mcrypt = new MCrypt();
        $id = $mcrypt->decrypt($id);
        $users = DB::table('users')->where('id', '=', $id)->first();
        if (count($users) > 0) {
            return view('api.users.resetPasswordForm', ['users' => $users]);
        } else {
            return response()->json(['message' => 'Email Address does not Match.', 'code' => 101]);
        }
    }

    public function changePassword(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $confirm_password = $request->confirm_password;
 
        if ($password == $confirm_password) {
            //$password = bcrypt($request->password);
            // print_r(Hash::make($request->password));exit;
            //print_r(bcrypt($request->password));exit;
            $user = DB::table('users')
                    ->where('email', $email)
                    ->update(['password' => $password]);
           
            if($user > 0){
                echo 'Password has been Change Successfully.';die;
            }else{
                echo 'Password hasnot been Change.';die;
            }
        }
    }

}
