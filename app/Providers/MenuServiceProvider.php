<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontlayouts.menu-header', function ($view) {
            $getCategories = \App\Categories::select('id', 'name', 'slug')->get()->toArray();
            if (!empty($getCategories) && count($getCategories) > 0) {
                foreach ($getCategories as $getCategoryKey => $getCategoryValue) {
                    $getSubCategoryOne = \App\SubCategories::select('sub_category_name as name', 'id','sub_category_slug')->where('category_id', $getCategoryValue['id'])->where('parent', 0)->where('status', 'Active')->get()->toArray();
                    foreach ($getSubCategoryOne as $getSubCategoryOneKey => $getSubCategoryOneValue) {
                        $getSubCategoryTwo = \App\SubCategories::select('sub_category_name as name', 'id','sub_category_slug')->where('category_id', $getCategoryValue['id'])->where('parent', $getSubCategoryOneValue['id'])->where('status', 'Active')->get()->toArray();
                        $getSubCategoryOne[$getSubCategoryOneKey]['subCategoryTwo'] = $getSubCategoryTwo;
                    }
                    $getCategories[$getCategoryKey]['subCategoryOne'] = $getSubCategoryOne;
                }
            }
            /*echo '<pre>';
            print_r($getCategories); exit;*/
            $view->with('categories', $getCategories);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
