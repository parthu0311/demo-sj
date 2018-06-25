<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\validate;
use Illuminate\Support\Facades\Session;
use App\Http\Helper;

class AdminRoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $permission = Helper::checkActionPermission('admin', 'privileges');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('adminRole/privilegesList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function createRole() {
        $permission = Helper::checkActionPermission('admin', 'addRole');
        if ($permission === 0) {
            return view('error.301');
        } 
        return view('adminRole/addRole');
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function storeRole(Request $request) {
            $permission = Helper::checkActionPermission('admin', 'addRole');
         //   print_r($permission);die;
            if ($permission === 0) {
                return view('error.301');
            }
            $this->validate($request, [
                'role_name' => 'required|max:255',
            ]);

            $users = DB::table('role_master')->insert(
                    [
                        'role_name' => $request->role_name,
                        'role_fun_name' => 'admin_' . strtolower(str_replace(' ', '_', $request->role_name)) . '_array',
                        'Status' => 'Active',
                        'Created_by' => $request->session()->get('userData')->id,
                        'Created_at' => Helper::get_curr_datetime()
                    ]
            );
            return redirect('admin/privileges');
        }*/

    public function privileges(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'privileges');
        if ($permission === 0) {
            return view('error.301');
        } 
        
        $view_data = array();
        $UserType = $request->type;
        $Rolename = $request->role_name;


        Session::get('roleMasterData')->role_fun_name;


        $PrivileageData = array();
        if($UserType != ''){
             $PrivileageData = Helper::get_user_privileges('first', 'user_privileges.role_id = ' . $UserType);
        }

        if(isset($Rolename))
        {
            if(($Rolename != "admin") && ($Rolename != "super admin"))
            {
                $data = $this->get_front_menu_action();
            }
            else
            {
                $data = $this->get_menu_action();
            }
        }
        else
        {
            $data = $this->get_menu_action();
        }
        $AdminRole = DB::table('role_master')->where('status', '=', 'Active')->get(); // To Get Record For Dynamic Dropdown role

        $view_data['PrivilagesData'] = $data;
        $view_data['Privilages'] = $PrivileageData; //echo "<pre>";print_r($PrivileageData);exit;
        $view_data['UserType'] = $UserType;
        $view_data['role_name'] = $Rolename;
        $view_data['AdminRole'] = $AdminRole;

        /* Update Privilidge for the role start */
        if ($request->isMethod('post')) {
           $actionId = $request->actionId;
           $UserType = $request->UserType;

            $PrivileageData = Helper::get_user_privileges('first', 'user_privileges.role_id = ' . $UserType);
          
            $this->validate($request, [
                'UserType' => 'required|max:255',
            ]); 

           
           // $flgUpdate = false;
            $data = array();
            $data['role_id'] = $UserType;
            $data['Permission'] = json_encode($actionId);
            
            if (isset($PrivileageData) && !empty($PrivileageData)) {
                $users = DB::table('user_privileges')->where('id', $PrivileageData[0]->id)->update([
                    'role_id' => $UserType,
                    'Permission' => $data['Permission'],
                    'Updated_at' => Helper::get_curr_datetime(),
                    'Updated_by' => $request->session()->get('userData')->id
                ]);


                if ($users) {
                    $flgUpdate = true;
                }
            }

          /*  if ($flgUpdate) {*/
                $usrPermisionData = Helper::get_user_privileges('first', 'user_privileges.Permission != ""');
               // print_r($usrPermisionData);die;
                if (isset($usrPermisionData) && !empty($usrPermisionData)) {
                    $current = '';
                    $current .= '<?php  ';
                    foreach ($usrPermisionData as $permi) {
                        $functionName = $permi->role_fun_name;

                        $currPermision = json_decode($permi->Permission);
                        $filed = app_path('Http/user_permission_helper.php');
                        $current .= PHP_EOL . PHP_EOL;
                        $current .= '//' . $permi->role_id . ' user rights array' . PHP_EOL;
                        $current .= 'if (!function_exists(\'' . $functionName . '\')) {' . PHP_EOL;
                        $current .= '    function ' . $functionName . '() {' . PHP_EOL;
                        $current .= ' $arr = ' . var_export($currPermision, true) . ';' . PHP_EOL . PHP_EOL . PHP_EOL;
                        $current .= ' return $arr;' . PHP_EOL . PHP_EOL . PHP_EOL;
                        $current .= '    }' . PHP_EOL;
                        $current .= '}' . PHP_EOL;
                        file_put_contents($filed, $current);
                    }
                    $current .= ' ?>';
                }
                return redirect('admin/privileges?type='.$UserType.'&role_name='.$Rolename)
                    ->with('view_data' ,$view_data );
                die;
            }
       /* }*/

        /* Update Privilidge for the role end */
        return view('adminRole/privilegesList', ['view_data' => $view_data]);
    }
   

    //============= start : Get Menu Action ============ //
    public function get_menu_action() {

        $MenuAction = DB::select('select act.action_id as Id,act.name as ActionName,act.controller,act.action,act.visible,act.comman_action,act.parent_id as ParentActionId,mnu.menu_id as MenuId,mnu.name as MnuName,mnu.action_id'
                        . ' from action_master as act Left Join menu_master as mnu ON act.menu_id = mnu.menu_id');

        if (count($MenuAction) > 0) {
            $data = $MenuAction;
            $ActionArr = array();
            $i = 0;
            foreach ($data as $val) {
                if ($val->MenuId) {
                    $subAct = array();
                    // print_r($val);exit;

                    $ActionArr[$val->MnuName]['MenuId'] = $val->MenuId;
                    $ActionArr[$val->MnuName]['MenuName'] = $val->MnuName;

                    $subAct['Id'] = $val->Id;
                    $subAct['Controller'] = $val->controller;
                    $subAct['Action'] = $val->action;
                    $subAct['ActionName'] = $val->ActionName;
                    $subAct['Visible'] = $val->visible;
                    $subAct['ParentActionId'] = $val->ParentActionId;

                    $ActionArr[$val->MnuName]['SubAction'][] = $subAct;
                }
                if ($val->comman_action == 'Yes') {
                    $commActArr = array();
                    $commActArr['Id'] = $val->Id;
                    $commActArr['Controller'] = $val->controller;
                    $commActArr['Action'] = $val->action;
                    $commActArr['ActionName'] = $val->ActionName;
                    $commActArr['Visible'] = $val->visible;
                    $ActionArr['CommanAction'][] = $commActArr;
                }
                $i++;
            }
            return $ActionArr;
        }
        return false;
    }


    //============= start : Get Front Menu Action ============ //
    public function get_front_menu_action() {

        $MenuAction = DB::select('select act.action_id as Id,act.name as ActionName,act.controller,act.action,act.visible,act.comman_action,act.parent_id as ParentActionId,mnu.menu_id as MenuId,mnu.name as MnuName,mnu.action_id'
            . ' from front_action_master as act Left Join front_menu_master as mnu ON act.menu_id = mnu.menu_id');



        if (count($MenuAction) > 0) {
            $data = $MenuAction;
            $ActionArr = array();
            $i = 0;
            foreach ($data as $val) {
                if ($val->MenuId) {
                    $subAct = array();
                    // print_r($val);exit;

                    $ActionArr[$val->MnuName]['MenuId'] = $val->MenuId;
                    $ActionArr[$val->MnuName]['MenuName'] = $val->MnuName;

                    $subAct['Id'] = $val->Id;
                    $subAct['Controller'] = $val->controller;
                    $subAct['Action'] = $val->action;
                    $subAct['ActionName'] = $val->ActionName;
                    $subAct['Visible'] = $val->visible;
                    $subAct['ParentActionId'] = $val->ParentActionId;

                    $ActionArr[$val->MnuName]['SubAction'][] = $subAct;
                }
                if ($val->comman_action == 'Yes') {
                    $commActArr = array();
                    $commActArr['Id'] = $val->Id;
                    $commActArr['Controller'] = $val->controller;
                    $commActArr['Action'] = $val->action;
                    $commActArr['ActionName'] = $val->ActionName;
                    $commActArr['Visible'] = $val->visible;
                    $ActionArr['CommanAction'][] = $commActArr;
                }
                $i++;
            }
            return $ActionArr;
        }
        return false;
    }

}
