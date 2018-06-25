<?php

namespace App\Providers;

use App\MenuMaster;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Http\Helper;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('layouts.sidebar', function ($view) {

            $Menu_query = "select mnu.menu_id,
                                  mnu.parent_id,
                                  mnu.name,
                                  mnu.show_in_menu,
                                  mnu.icon_cis,
                                  mnu.show_in_menu,
                                  act.action_id as MnuActionId,
                                  act.controller,
                                  act.action
                          from menu_master as mnu 
                          Left Join action_master as act ON act.action_id = mnu.action_id
                          Where mnu.parent_id = 0 Order by mnu.sort_order Asc";
            $menu_array = DB::select($Menu_query);
            /*$test = MenuMaster::find('menu_id')->WithAction()->toarray();


            echo '<pre>';
            print_r($test);
            echo '</pre>';
            exit;*/
            if (count($menu_array) > 0) {
                $menuData = $menu_array;
                $menuArr = array();
                if (isset($menuData) && !empty($menuData)) {
                    $i = 0;
                    foreach ($menuData as $val) {
                        $menuArr[$i]['MenuId'] = $val->menu_id;
                        $menuArr[$i]['ParentMenuId'] = $val->parent_id;
                        $menuArr[$i]['Name'] = $val->name;
                        $menuArr[$i]['MnuActionId'] = $val->MnuActionId;
                        $menuArr[$i]['Controller'] = $val->controller;
                        $menuArr[$i]['Action'] = $val->action;
                        $menuArr[$i]['IconCls'] = $val->icon_cis;
                        $menuArr[$i]['ShowInMenu'] = $val->show_in_menu;
                        $menuArr[$i]['SubMenu'] = '';

                        $SubMenu_query = "select mnu.menu_id,mnu.parent_id,mnu.name,act.action_id as MnuActionId,mnu.show_in_menu,act.controller,act.action"
                            . " from menu_master as mnu Left Join action_master as act ON act.action_id = mnu.action_id"
                            . " Where mnu.parent_id = ".$val->menu_id." Order by mnu.sub_sort_order Asc";
                        $Submenu_array = DB::select($SubMenu_query);
                        // print_r($Submenu_array);//die;

                        if (count($Submenu_array) > 0) {
                            $subMenuData = $Submenu_array;
                            if (isset($subMenuData) && !empty($subMenuData)) {
                                $j = 0;
                                foreach ($subMenuData as $val1) {
                                    $subMnu = array();
                                    $subMnu['MenuId'] = $val1->menu_id;
                                    $subMnu['ParentMenuId'] = $val1->parent_id;
                                    $subMnu['Name'] = $val1->name;
                                    $subMnu['MnuActionId'] = $val1->MnuActionId;
                                    $subMnu['Controller'] = $val1->controller;
                                    $subMnu['Action'] = $val1->action;
                                    $subMnu['ShowInMenu'] = $val1->show_in_menu;

                                    $menuArr[$i]['SubMenu'][] = $subMnu;
                                    $j++;
                                }
                            }
                        }
                        $i++;
                    }

                }
           //     print_r($menuArr);die;
                $view->with('menuArray', $menuArr);
            } else {
                $menuArr = array();
                $view->with('menuArray', $menuArr);
            }
           // print_r($menu_array);die;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
