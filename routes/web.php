<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('CCAvanue', 'TestController@CCAvanue');

//Auth::routes();
Route::prefix('admin')->group(function(){
    Route::get('/', function () {
        return view('admin/login');
    });
    Route::any('login', 'AdminController@adminLogin');
    Route::any('loginPost', 'AdminController@dashboard');


    Route::group(['middleware' => 'auth'], function() {

        Route::get('/', 'AdminController@index');
        Route::get('/set_order', 'AdminController@set_order');

        //Route::any('admin', 'AdminController@adminLogin');
        Route::any('dashboard', 'AdminController@index');
        Route::any('resetpassword', 'AdminController@forgotpassword');
        Route::any('changepassword', 'AdminController@changepassword');
        //Route::any('login', 'AdminController@dashboard');
        Route::get('logout', 'AdminController@logout');
        Route::get('resetpasswordpage/{token}', 'AdminController@resetpasswordpage');

        /*------------ Admin : AdminUser Route ----------- */
        Route::get('adminusers', 'AdminController@show');
        Route::get('createAdminUser', 'AdminController@create');
        Route::post('create', 'AdminController@store');
        Route::get('editadminUser/{id}', 'AdminController@edit');
        Route::post('update/{id}', 'AdminController@update');
        Route::post('delete','AdminController@destroy');
        Route::post('activeInactiveStatus','AdminController@activeInactiveStatus');
        Route::any('ajaxList/','AdminController@adminAjaxList');

        Route::any('test/','AdminController@test');

        /* ---------- Admin: Role Permission Route List --------- */
        Route::any('privileges', 'AdminRoleController@privileges');
        Route::get('addRole', 'AdminRoleController@createRole');
      //  Route::get('internalUsers', 'AdminRoleController@getInternalUsers');
        Route::post('storeRole', 'AdminRoleController@storeRole');

        // ============== Profile Routes =========//
        Route::get('editProfile', 'AdminController@editProfile');
        Route::get('viewProfile', 'AdminController@viewProfile');
        Route::post('updateProfile', 'AdminController@updateProfile');
        Route::get('profilechangePassword', 'AdminController@profilechangePassword');
        Route::post('changepwdProfile', 'AdminController@changepwdProfile');

        /*----------------Product Routes-------------------*/

        /* Customer COntroller end */

        /*Route::get('product-create', 'AdminProductController@ProductCreate');
        Route::any('ProductCreatePost', 'AdminProductController@ProductCreatePost');
        Route::any('product-edit/{id}', 'AdminProductController@ProductEdit');
        Route::any('upload_image_of_product', 'AdminProductController@upload_image_of_product');
        Route::any('deletProductImage', 'AdminProductController@deletProductImage');
        Route::any('ProductEditPost', 'AdminProductController@ProductEditPost');
        Route::get('product-category-list', 'AdminProductController@productcategoryListview');
        Route::any('productList', 'AdminProductController@productList');
        Route::post('activeInactiveProductStatus','AdminProductController@activeInactiveProductStatus');
        Route::post('deleteProduct','AdminProductController@deleteProduct');*/

        /*-----------------------Product Category------------------------*/
        Route::get('product-category-list', 'AdminCategoryController@productCategoryListView');
        Route::any('productCategoryList', 'AdminCategoryController@productCategoryList');
        Route::get('product-category-reorder', 'AdminCategoryController@productCategoryReOrder');
        Route::any('CategoryReorderPost', 'AdminCategoryController@CategoryReorderPostData');
        Route::get('product-category-create', 'AdminCategoryController@ProductCategoryCreate');
        Route::any('ProductCategoriesCreatePostData', 'AdminCategoryController@ProductCategoriesCreatePostData');
        Route::get('product-category-edit/{id}', 'AdminCategoryController@ProductCategoryEditData');
        Route::any('ProductCategoriesEditPostData/{id}', 'AdminCategoryController@ProductCategoriesEditPostData');
        Route::post('actInactProductCategoryStatus','AdminCategoryController@activeInactiveProductCategoryStatusData');
        Route::post('deleteProCate','AdminCategoryController@deleteProCate');

        /*-----------------------Product Category------------------------*/

        /*-----------------------Sub Product Category------------------------*/
        Route::any('productSubCategoryListGet', 'AdminSubCategoryController@productSubCategoryList');
        Route::post('AddSubCategory', 'AdminSubCategoryController@AddSubCategory');
        Route::post('actInactProductSubCategoryStatus','AdminSubCategoryController@actInactProductSubCategoryStatus');
        Route::post('deleteProSubCate','AdminSubCategoryController@deleteProSubCate');
        Route::any('change_order_save','AdminSubCategoryController@change_order_save');
        Route::post('AddfilterInSubCategory','AdminSubCategoryController@AddfilterInSubCategory');

        /*-----------------------Sub Product Category------------------------*/

        /*-----------------------Product Brand------------------------*/
        Route::get('brand-list', 'AdminProductBrandController@brandListView');
        Route::any('BrandListAjax', 'AdminProductBrandController@BrandListAjax');
        Route::get('brand-create', 'AdminProductBrandController@brandCreateView');
        Route::any('brandCreatePostData', 'AdminProductBrandController@brandCreatePostData');
        Route::any('brand-edit/{id}', 'AdminProductBrandController@brandEdit');
        Route::any('brandEditPost/{id}', 'AdminProductBrandController@brandEditPost');
        Route::post('actInactbrandStatus','AdminProductBrandController@actInactbrandStatus');
        Route::post('deletebrand','AdminProductBrandController@deletebrand');

        /*-----------------------Product GST------------------------*/
        Route::get('gst-management-list', 'AdminProductGSTController@GSTManagemntListView');
        Route::any('GSTManagemntListAjax', 'AdminProductGSTController@GSTManagemntListAjax');
        Route::get('gst-management-create', 'AdminProductGSTController@GSTManagementCreateView');
        Route::any('GSTManagementCreatePostData', 'AdminProductGSTController@GSTManagementCreatePostData');
        Route::any('gst-management-edit/{id}', 'AdminProductGSTController@GSTManagementEdit');
        Route::any('GSTManagementEditPost/{id}', 'AdminProductGSTController@GSTManagementEditPost');
        Route::post('actInactGSTManagementStatus','AdminProductGSTController@actInactGSTManagementStatus');
        Route::post('deleteGSTManagement','AdminProductGSTController@deleteGSTManagement');

        /*-----------------------Size Chart------------------------*/
        Route::get('size-chart-list', 'AdminSizeChartController@SizeChartListView');
        Route::any('SizeChartListAjax', 'AdminSizeChartController@SizeChartListAjax');
        Route::get('size-chart-create', 'AdminSizeChartController@SizeChartCreateView');
        Route::any('SizeChartCreatePostData', 'AdminSizeChartController@SizeChartCreatePostData');
        Route::any('size-chart-edit/{id}', 'AdminSizeChartController@SizeChartEdit');
        Route::any('SizeChartEditPost/{id}', 'AdminSizeChartController@SizeChartEditPost');
        Route::post('actInactSizeChartStatus','AdminSizeChartController@actInactSizeChartStatus');
        Route::post('deleteSizeChart','AdminSizeChartController@deleteSizeChart');


        /*-----------------------Product------------------------*/
        Route::get('product-management-list', 'AdminProductDataController@ProductListView');
        Route::any('ProductListAjax', 'AdminProductDataController@ProductListAjax');
        Route::get('product-management-create', 'AdminProductDataController@ProductManagementCreateView');
        Route::any('productCreatePostData', 'AdminProductDataController@productCreatePostData');
        Route::any('get_sub_cat_by_cat', 'AdminProductDataController@get_sub_cat_by_cat');
        Route::any('get_sub_cat_type_by_cat', 'AdminProductDataController@get_sub_cat_type_by_cat');
        Route::any('get_questionnaire_by_id', 'AdminProductDataController@get_questionnaire_by_id');
        Route::any('product-management-edit/{id}', 'AdminProductDataController@ProductManagementEdit');
        Route::any('ProductManagementEditPost/{id}', 'AdminProductDataController@ProductManagementEditPost');
        Route::any('get_questionnaire_by_id_edit', 'AdminProductDataController@get_questionnaire_by_id_edit');
        Route::post('actInactProductManagementStatus','AdminProductDataController@actInactProductManagementStatus');
        Route::post('deleteProductManagement','AdminProductDataController@deleteProductManagement');
        Route::get('product-images/{id}','AdminProductDataController@ProductImages');
        Route::any('productPost/{id}','AdminProductDataController@productPost');
        Route::any('deleteImage','AdminProductDataController@deleteImage');
        Route::any('upload_image_of_product', 'AdminProductDataController@upload_image_of_product');
        Route::any('upload_image_of_product_base64', 'AdminProductDataController@upload_image_of_product_base64');
        Route::any('upload_image_of_product_main', 'AdminProductDataController@upload_image_of_product_main');
        Route::any('upload_image_of_product_main_base64', 'AdminProductDataController@upload_image_of_product_main_base64');
        Route::any('deleteVariant','AdminProductDataController@deleteVariant');
        /*-------------- QuestionnaireForCombinations ------------------*/

        Route::get('collection-type-list', 'AdminQuestionnaireController@Questionnaireview');
        Route::any('collectionList', 'AdminQuestionnaireController@questionnaireList');
        Route::any('collection-for-combinations','AdminQuestionnaireController@GetQuestionnaireForCombinations');
        Route::post('collectionForCombinations/{id?}','AdminQuestionnaireController@QuestionnaireForCombinations');
        Route::any('collection-type-edit/{id}', 'AdminQuestionnaireController@QuestionnaireEdit');
        Route::post('activeInactivecollectionStatus','AdminQuestionnaireController@activeInactiveQuestionnaireStatus');
        Route::post('deletecollection','AdminQuestionnaireController@deleteQuestionnaire');


        /*-----------------------Home Main Slider------------------------*/
        Route::get('home-slider-list', 'AdminHomeSliderController@HomeSliderListView');
        Route::any('HomeSliderListAjax', 'AdminHomeSliderController@HomeSliderListAjax');
        Route::get('home-slider-create', 'AdminHomeSliderController@HomeSliderCreateView');
        Route::post('HomeSliderCreatePostData', 'AdminHomeSliderController@HomeSliderCreatePostData');
        Route::any('home-slider-edit/{id}', 'AdminHomeSliderController@HomeSliderEdit');
        Route::any('HomeSliderEditPost/{id}', 'AdminHomeSliderController@HomeSliderEditPost');
        Route::post('actInactSliderStatus','AdminHomeSliderController@actInactSliderStatus');
        Route::post('deleteHomeSlider','AdminHomeSliderController@deleteHomeSlider');

        /*-----------------------Home Main Collection------------------------*/
        Route::get('home-collection-list', 'AdminHomeCollectionController@HomeCollectionListView');
        Route::any('HomeCollectionListAjax', 'AdminHomeCollectionController@HomeCollectionListAjax');
        Route::get('home-collection-create', 'AdminHomeCollectionController@HomeCollectionCreateView');
        Route::post('HomeCollectionCreatePostData', 'AdminHomeCollectionController@HomeCollectionCreatePostData');
        Route::any('home-collection-edit/{id}', 'AdminHomeCollectionController@HomeCollectionEdit');
        Route::any('HomeCollectionEditPost/{id}', 'AdminHomeCollectionController@HomeCollectionEditPost');
        Route::post('actInactHomeCollectionStatus','AdminHomeCollectionController@actInactHomeCollectionStatus');
        Route::post('deleteHomeCollection','AdminHomeCollectionController@deleteHomeCollection');
        Route::any('home-collection-product/{id}', 'AdminHomeCollectionController@HomeCollectionProduct');
        Route::any('CollectionChoosableProductListAjax', 'AdminHomeCollectionController@CollectionChoosableProductListAjax');
        Route::any('CollectionProductListAjax', 'AdminHomeCollectionController@CollectionProductListAjax');
        Route::post('add_in_collection','AdminHomeCollectionController@add_in_collection');
        Route::post('removeProductFromCollection','AdminHomeCollectionController@removeProductFromCollection');
        Route::post('actInactProductCollectionStatus','AdminHomeCollectionController@actInactProductCollectionStatus');

        /*-----------------------Home Tag Collection------------------------*/
        Route::get('home-tag-collection-list', 'AdminTagCollectionController@HomeTagCollectionListView');
        Route::any('HomeTagCollectionListAjax', 'AdminTagCollectionController@HomeTagCollectionListAjax');
        Route::get('home-tag-collection-create', 'AdminTagCollectionController@HomeTagCollectionCreateView');
        Route::post('HomeTagCollectionCreatePostData', 'AdminTagCollectionController@HomeTagCollectionCreatePostData');
        Route::any('home-tag-collection-edit/{id}', 'AdminTagCollectionController@HomeTagCollectionEdit');
        Route::any('HomeTagCollectionEditPost/{id}', 'AdminTagCollectionController@HomeTagCollectionEditPost');
        Route::post('actInactHomeTagCollectionStatus','AdminTagCollectionController@actInactHomeTagCollectionStatus');
        Route::post('deleteHomeTagCollection','AdminTagCollectionController@deleteHomeTagCollection');

        Route::any('home-tag-collection-product/{id}', 'AdminTagCollectionController@HomeTagCollectionProduct');
        Route::any('TagCollectionProductListAjax', 'AdminTagCollectionController@TagCollectionProductListAjax');
        Route::post('add_in_tag_collection','AdminTagCollectionController@add_in_collection');
        Route::post('removeProductFromTagCollection','AdminTagCollectionController@removeProductFromCollection');
        Route::post('actInactProductTagCollectionStatus','AdminTagCollectionController@actInactProductCollectionStatus');

        /*-----------------------Home Tag Collection------------------------*/

        Route::any('offer-collection-product', 'AdminOfferZoneCollectionController@HomeTagCollectionProduct');
        Route::any('offerCollectionProductListAjax', 'AdminOfferZoneCollectionController@offerCollectionProductListAjax');
        Route::post('add_in_offer_collection','AdminOfferZoneCollectionController@add_in_offer_collection');
        Route::post('removeProductFromOfferCollection','AdminOfferZoneCollectionController@removeProductFromOfferCollection');
        Route::post('actInactProductOfferCollectionStatus','AdminOfferZoneCollectionController@actInactProductOfferCollectionStatus');

        /* ------------ Offer Routes ------------*/
        Route::any('offer-creation', 'AdminOfferCollectionController@OfferCreationView');
        Route::any('get_Offer_creation', 'AdminOfferCollectionController@get_Offer_creation');
        Route::post('CreateOfferPost', 'AdminOfferCollectionController@CreateOfferPost');
        Route::any('OfferListAjax', 'AdminOfferCollectionController@OfferListAjax');
        Route::any('get_Offer_edit', 'AdminOfferCollectionController@get_Offer_edit');
        Route::post('actInactOfferStatus','AdminOfferCollectionController@actInactOfferStatus');
        Route::post('deleteOffer','AdminOfferCollectionController@deleteOffer');

        /* ------------ Static Pages Routes ------------*/




        Route::get('staticpages/staticpagelist', 'PageContentController@show');
        Route::get('staticpages/createStaticPage', 'PageContentController@create');
        Route::post('staticpages/create', 'PageContentController@store');
        Route::get('staticpages/editStaticPage/{id}', 'PageContentController@edit');
        Route::post('staticpages/update/{id}', 'PageContentController@update');
        Route::post('staticpages/delete','PageContentController@destroy');
        Route::post('staticpages/activeInactiveStatus','PageContentController@activeInactiveStatus');
        Route::any('staticpages/ajaxstaticPageList/','PageContentController@ajaxstaticPageList');

        /* ------------ Email Template Routes ------------*/
        Route::get('emailtemplate/emailtemplatelist', 'EmailTemplateController@show');
        Route::get('emailtemplate/createemailtemplate', 'EmailTemplateController@create');
        Route::post('emailtemplate/create', 'EmailTemplateController@store');
        Route::get('emailtemplate/editemailtemplate/{id}', 'EmailTemplateController@edit');
        Route::post('emailtemplate/update/{id}', 'EmailTemplateController@update');
        Route::post('emailtemplate/delete','EmailTemplateController@destroy');
        Route::post('emailtemplate/activeInactiveStatus','EmailTemplateController@activeInactiveStatus');
        Route::any('emailtemplate/ajaxemailtemplateList/','EmailTemplateController@ajaxemailtemplateList');

        /*-----------------------Web Site Users------------------------*/
        Route::get('site-users', 'AdminSiteUsersController@SiteUsersListView');
        Route::any('SiteUsersListAjax', 'AdminSiteUsersController@SiteUsersListAjax');
        Route::post('actInactSiteUsersStatus','AdminSiteUsersController@actInactSiteUsersStatus');
        Route::post('deleteSiteUsers','AdminSiteUsersController@deleteSiteUsers');
        /*Route::get('brand-create', 'AdminProductBrandController@brandCreateView');
        Route::any('brandCreatePostData', 'AdminProductBrandController@brandCreatePostData');
        Route::any('brand-edit/{id}', 'AdminProductBrandController@brandEdit');
        Route::any('brandEditPost/{id}', 'AdminProductBrandController@brandEditPost');
        */
    });

});
require __DIR__.'/front.php';