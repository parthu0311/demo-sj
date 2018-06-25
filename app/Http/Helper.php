<?php

namespace App\Http;

use App\ActionMaster;
use App\FrontActionMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\validate;
use Illuminate\Support\Facades\Session;


class Helper {

    //============= start : Get Current url ============ //
    public static function GetCurrentUrl() {
        $url = url()->current();
        $UrlArray = array_reverse(explode('/', $url));
        return $UrlArray;
    }

    //===================slug========================//

    public static function slug_generator($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }

    //============= start : Check Action Permission ============ //
    public static function checkActionPermission($controller, $action) {

        $role = Session::get('userData')->role_id;
        $funName = Session::get('roleMasterData')->role_fun_name;
        $UserPrivilage = $funName();

        if (isset($UserPrivilage) && !empty($UserPrivilage)) {
            $ActionMaster = ActionMaster::where([ ["controller", "=", $controller], ["action", "=", $action] ])->get();
            $data = array();
            if (count($ActionMaster) > 0) {
                $data = $ActionMaster[0];
               
                if (in_array($data->action_id, $UserPrivilage)) {
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
             return 0;
        }
       
    }

    public static function checkFrontActionPermission($controller, $action) {

        $role = Session::get('InternalData')->role_id;
        $funName = Session::get('InternalroleMasterData')->role_fun_name;
        $UserPrivilage = $funName();
        if (isset($UserPrivilage) && !empty($UserPrivilage)) {
            $ActionMaster = FrontActionMaster::where([ ["controller", "=", $controller], ["action", "=", $action] ])->get()->toArray();

            $data = array();
            if (count($ActionMaster) > 0) {

                $data = $ActionMaster[0];
                /*echo '<pre>';
                print_r($data['action_id']);
                echo '</pre>';
                exit;*/

                if (in_array($data['action_id'], $UserPrivilage)) {
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return 0;
        }

    }

    //============= start : Current Date Time Exist ============ //

    public static function get_curr_datetime($format = 'Y-m-d H:i:s') {
        date_default_timezone_set('UTC');
        return date($format, strtotime(date('Y-m-d H:i:s')));
    }

    // ======== Search data =====//
    public static function get_search_data($aColumns = array()) {
        $SearchType = 'ORLIKE';
        /*
         * Paging
         */
        $per_page = 10;
        $offset = 0;

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $per_page = $_GET['iDisplayLength'];
            $offset = $_GET['iDisplayStart'];
        }

        /*
         * Ordering
         */
        $order_by = "";
        $sort_order = "";
        if (isset($_GET['iSortCol_0'])) {
            $order_by = "";
            $sort_order = "";

            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $order_by = $aColumns[intval($_GET['iSortCol_' . $i])];
                    $sort_order = $_GET['sSortDir_' . $i];
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $search_data = array();
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $search_data[$aColumns[$i]] = Helper::mysql_escape($_GET['sSearch']);
            }
            $SearchType = 'ORLIKE';
        }


        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $_GET['sSearch_' . $i] != '~') {
                $search_data[$aColumns[$i]] = Helper::mysql_escape($_GET['sSearch_' . $i]);
                $SearchType = 'ANDLIKE';
            }
        }
        $data = array();
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['search_data'] = $search_data;
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['SearchType'] = $SearchType;
        return $data;
    }
    
    // ======== Start : String escape  =====//
    public static function mysql_escape($inp) {
        if (is_array($inp))
            return array_map(__METHOD__, $inp);

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }
    
    /* =============== Start : or Like Condition function ======================= */
    public static function or_like_search($data) {
        if (!empty($data)) {
            $i = 0;
            foreach ($data as $key => $value) {
                if ($i == 0) {
                    // pass the first element of the array
                    $sub = '(' . $key . ' LIKE \'%' . $value . '%\' ';
                } else {
                    //$this->db->or_like('Linkname', $search_string_multiple);
                    $sub .= 'OR ' . $key . ' LIKE \'%' . $value . '%\' ';
                }
                $i++;
            }
            $sub .= ')';
            return $sub;
        }
        return false;
    }
    
    /* =============== Start : And search function ======================= */
    public static function and_like_search($data) {
        if (!empty($data)) {
            $i = 0;
            $sub = '';
            $querystr = array();
            $query = '';
            foreach ($data as $key => $value) {
                if ($i == 0) {
                    $sub = '( ';
                } else {
                    $sub = 'AND ';
                }

                if (strtoupper($value['Operator']) == 'LIKE') {
                    $querystr[] = $value['Field'] . ' LIKE \'%' . $value['Value'] . '%\' ';
                } else if (strtoupper($value['Operator']) == 'RANGE') {
                    if (isset($value['Condition']) && !empty($value['Condition'])) {
                        foreach ($value['Condition'] as $val) {
                            $querystr[] = $val['Field'] . " " . $val['Operator'] . " '" . $val['Value'] . "' ";
                        }
                    }
                } else if (strtoupper($value['Operator']) == 'IN') {
                    $querystr[] = $value['Field'] . " " . $value['Operator'] . " (" . $value['Value'] . ") ";
                } else {
                    $querystr[] = $value['Field'] . " " . $value['Operator'] . " '" . $value['Value'] . "' ";
                }

                $i++;
            }

            if (isset($querystr) && !empty($querystr)) {
                $query = '( ' . implode(' AND ', $querystr) . ' )';
            }
            return $query;
        }
        return false;
    }
    
    //============= start : checked id Exist ============ //
    public static function check_id_exists($where = array(), $table = '') {
        if (isset($where) && count($where) > 0 && $table != '') {
            $fetchdata = DB::select("select * from $table Where id In($where)");

            if (count($fetchdata) > 0)
                return count($fetchdata);
        }
        return false;
    }
    
    //====================== Start : Get Users Previleges ========//
     public static function get_user_privileges($result = 'all', $where = array()) {

        $query = "select user_privileges.*, role_master.* From user_privileges Left Join role_master ON role_master.role_id = user_privileges.role_id";
        if ($where) {
            $query .= " Where " . $where;
        }

        $UserPrivilegesresult = DB::select($query);
     //   print_r($UserPrivilegesresult);die;


        if (count($UserPrivilegesresult) > 0) {
            if ($result == 'first') {
                return $UserPrivilegesresult;
            }
        }
        return false;
    }
    public static function randomString($length = 9) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}

?>  