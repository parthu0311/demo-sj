<?php
$CurrentUrl = Helper::GetCurrentUrl();

if(count($CurrentUrl) > 5){
    $CurrentUrlArray = array_slice($CurrentUrl, 0, 3);
    $controller = $CurrentUrlArray[2];
    $action = $CurrentUrlArray[1]; 
}else{
    $CurrentUrlArray = array_slice($CurrentUrl, 0, 2);
    $controller = $CurrentUrlArray[1];
    $action = $CurrentUrlArray[0];
}
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/avatar.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ ucfirst(Session::get('userData')->first_name.' '.Session::get('userData')->last_name) }}</p>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Main Navigation</li>

            <?php
            $class = $controller;
            $action = $action;

            if (isset($menuArray) && !empty($menuArray)) {
                $displayMenu = 0; //print_r($menuArray); die;
                foreach ($menuArray as $val) {
                    if ($val['ShowInMenu'] == 'Yes') {
                      //  echo "1";
                        $displayMenu = 1;

                        $MenuId = $val['MenuId'];
                        $Name = $val['Name'];
                   //     echo $Name;
                        $icocls = $val['IconCls'];
                        $MnuController = $val['Controller'];
                        $MnuAction = $val['Action'];

                        $clasActive = '';
                        $ActMenuId = "";

                        $getActionMenuQuery = "Select act.action_id,IF(mnu.parent_id > 0, mnu.parent_id, act.menu_id) as MenuId"
                                . " From action_master as act Left Join menu_master as mnu ON act.menu_id = mnu.menu_id"
                                . " Where controller='" . $class . "' And action='" . $action . "'";

                       // die;

                        $ActionMenuResult = DB::select($getActionMenuQuery);

                        if (count($ActionMenuResult) > 0) {
                            $data = $ActionMenuResult[0];
                            $ActMenuId = $data->MenuId;
                        }
                        /*echo $action.'<br>';
                        echo $MnuAction;*/
                        if ($class == $MnuController && $action == $MnuAction) {
                            $clasActive = 'active';
                        } else if ($MenuId == $ActMenuId) {
                            $clasActive = 'active';
                        }
                        //echo '================'.$class.'============='.$MnuController;
                        $url = asset($MnuController . '/' . $MnuAction);
                        
                        if(Helper::checkActionPermission($MnuController, $MnuAction)){
                          //  echo Helper::checkActionPermission($MnuController, $MnuAction);
                            $subcls = '';
                            $SubMenu = '';
                            if (isset($val['SubMenu']) && !empty($val['SubMenu'])) {
                                $SubMenu = $val['SubMenu'];
                                $subcls = 'treeview';
                                $k = 0;
                                foreach ($SubMenu as $subVal) {
                                    $SubMnuName = $subVal['Name'];
                                    $SubMnuController = $subVal['Controller'];
                                    $SubMnuAction = $subVal['Action'];
                                    /*echo $action.'<br>';
                                    echo $SubMnuAction.'<br>';*/
                                    if ($class == $SubMnuController && $action == $SubMnuAction) {
                                        $clasActive = 'active';
                                    }
                                    $k++;
                                }
                            }
                        }else {
                            $displayMenu = 0;
                        }
                        


                       /* $role = Session::get('userData')->role_id;
                        $funName = Session::get('roleMasterData')->role_fun_name;
                        $UserPrivilage = $funName();

                        if (isset($UserPrivilage) && !empty($UserPrivilage)) {
                            $ActionMaster = DB::table('action_master')->where("controller", "=", $MnuController)->where("action", "=", $MnuAction)->first();
                            $data = array();
                            if (count($ActionMaster) > 0) {
                                $data = $ActionMaster;
                                $subcls = '';
                                $SubMenu = '';
                                if (in_array($data->action_id, $UserPrivilage)) {
                                    if (isset($val['SubMenu']) && !empty($val['SubMenu'])) {
                                        $SubMenu = $val['SubMenu'];
                                        $subcls = 'treeview';
                                        $k = 0;
                                        foreach ($SubMenu as $subVal) {
                                            $SubMnuName = $subVal['Name'];
                                            $SubMnuController = $subVal['Controller'];
                                            $SubMnuAction = $subVal['Action'];

                                            if ($class == $SubMnuController && $action == $SubMnuAction) {
                                                $clasActive = 'active';
                                            }
                                            $k++;
                                        }
                                    }
                                } else {
                                    $displayMenu = 0;
                                }
                            }
                        } */
            if ($displayMenu == 1) {

            //   print_r($SubMenu);
            ?>
            <?php if (isset($SubMenu) && !empty($SubMenu)) { ?>
            <li class="<?php echo $subcls; ?> <?php echo $clasActive; ?>">
            <?php } else { ?>
            <li class="<?php echo $subcls; ?> <?php echo $clasActive; ?>"><a href="<?php echo $url; ?>"><i class="<?php echo $icocls; ?>"></i> <span><?php echo $Name; ?></span></a>
                <?php } ?>

                <?php
                if (isset($SubMenu) && !empty($SubMenu)) {
                ?>

                <a href="#">
                    <i class="<?php echo $icocls;?>"></i> <span><?php echo $Name; ?></span>
                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php

                    // print_r($SubMenu);exit;
                    foreach ($SubMenu as $subVal) {
                        /*echo '<pre>';
                        print_r($subVal);exit;*/
                    $SubMnuName = $subVal['Name'];
                    $SubMnuController = $subVal['Controller'];
                    $SubMnuAction = $subVal['Action'];
                    $subclassActive = '';
                    $checkActionPermissionvar = false;

                    if ($subVal['ShowInMenu'] == 'Yes') {
                    if(Helper::checkActionPermission($SubMnuController, $SubMnuAction)){
                     $url = asset($SubMnuController . '/' . $SubMnuAction);

                    if ($action == $SubMnuAction) {
                        $subclassActive = 'active';
                    }
                    ?>
                    <li class="<?php echo $subclassActive; ?>"><a href="<?php echo $url; ?>"><?php echo $SubMnuName; ?></a></li>
                    <?php
                    }

                    /* $role = Session::get('userData')->role_id;
                     $funName = Session::get('roleMasterData')->role_fun_name;
                     $UserPrivilage = $funName();

                     if (isset($UserPrivilage) && !empty($UserPrivilage)) {
                         $ActionMaster = DB::table('action_master')->where("controller", "=", $SubMnuController)->where("action", "=", $SubMnuAction)->first();
                         $data = array();
                         if (count($ActionMaster) > 0) {
                             $data = $ActionMaster;
                             $subcls = '';
                             $SubMenu = '';
                             if (in_array($data->action_id, $UserPrivilage)) {
                                 $url = asset($SubMnuController . '/' . $SubMnuAction);
                                 if ($class == $SubMnuController && $action == $SubMnuAction) {
                                     $subclassActive = 'active';
                                 }
                                 ?>
                                 <li class="<?php echo $subclassActive; ?>"><a href="<?php echo $url; ?>"><?php echo $SubMnuName; ?></a></li>
                                 <?php
                             }
                         }
                     } */
                    }
                    }
                    ?>
                </ul>
                <?php
                }
                ?>
            </li>
        <?php
        // }
        }
                    }
                   
                  
                    //$arr=array('Global Settings','Account Management','');
                    //  if(!in_array($Name, $arr)){

                        }
                    //    die;
                    }
                    ?>

















<!-- <li class="active"><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

<li class="active"><a href="{{ url('/admin/adminusers') }}"><i class="fa fa-table"></i> <span>Manage Admin Users</span></a></li>

<li class="active"><a href="{{ url('admin/privileges') }}"><i class="fa fa-table"></i> <span>Admin Role</span></a></li>


<!--  <li class=""><a href="{{ url('/admin/formcontrol') }}"><i class="fa fa-edit"></i> <span>Form Controls</span></a></li> -->
<!--   <li><a href="{{ url('/admin/listingcontrol') }}"><i class="fa fa-table"></i> <span>Listing Controls</span></a></li> -->
<!--  <li><a href="{{ url('/admin/loading')}}"><i class="fa fa-spinner fa-pulse fa-fw"></i> <span>Loader</span></a></li> -->
<!--  <li><a href="{{ url('/admin')}}"><i class="fa fa-sign-in"></i> <span>Login</span></a></li> 
<li class="treeview">
  <a href="#">
    <i class="fa fa-th"></i> <span>Multilevel Menu Demo</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
    <li class="">
      <a href="#"><i class="fa fa-circle-o"></i> Level One
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
        <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
        <li class="">
          <a href="#"><i class="fa fa-circle-o"></i> Level Two
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
  </ul>
</li> -->
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>