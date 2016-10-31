<?php

	/*
		|--------------------------------------------------------------------------
		| Application Routes
		|--------------------------------------------------------------------------
		|
		| Here is where you can register all of the routes for an application.
		| It's a breeze. Simply tell Laravel the URIs it should respond to
		| and give it the controller to call when that URI is requested.
		|
	*/

	if(isset($_COOKIE['Language'])){
		session(['languageActive' => $_COOKIE['Language']]);
	} else {
		session(['languageActive' => 'English']);
		setcookie("Language", 'English', time()+3600*24*365, '/');
	}
	
	//Admin Role
	//Route::group(array('middleware' => ['auth', 'roles']), function()
	//Route::group(['prefix' => 'admin', 'middleware'=>'auth'], function () {
	Route::group(array('middleware' => ['auth','site']), function()
	{ 	
		// Useful Information
		Route::resource('admin/useful_information/useful_category', 'Admin\UsefulInfoCategoryController');
		Route::resource('admin/useful_information/useful_listing', 'Admin\UsefulInfoListingController');

		// information
		Route::resource('admin/information/committee', 'Admin\CommitteeController');
		Route::resource('admin/information', 'Admin\InformationController');
		//Admin 
		Route::get('admin', 'Admin\CommonController@index');
		Route::get('admin/dashboard', 'Admin\CommonController@index');
		Route::get('admin/calendar', 'Admin\CommonController@calendar');
		//Users
		Route::resource('admin/user_mgr/user','Admin\UserController');
		// Group Role
		Route::resource('admin/user_mgr/group_role', 'Admin\GroupRoleController');
		Route::post('admin/group_role_update', 'Admin\GroupRoleController@updateGroupRolePermission');
		//User Group
		Route::resource('admin/user_mgr/group_user','Admin\GroupUserController');
		//Permission
		Route::get('admin/permission/Permission_List', 'Admin\PermissionController@index');
		Route::get('admin/permission/setPermission', 'Admin\PermissionController@create');
		Route::post('admin/permission/store', 'Admin\PermissionController@store');
		Route::get('admin/permission/edit/{id}', 'Admin\PermissionController@edit');
		Route::post('admin/permission/update', 'Admin\PermissionController@update');
		//Route::get('admin/role/RoleList', ['uses' => 'admin\RoleController@index','roles' => ['admin']]);
		Route::get('admin/role/RoleList', 'admin\RoleController@index');
		//Front menu
		Route::resource('admin/menu_mgr/fmenu','Admin\FMenuController');
		Route::resource('admin/menu_mgr/mtype','Admin\MenuTypeController');
		Route::get('admin/menu_mgr/menuParent','Admin\FMenuController@menuParent');
		//All configuration
		Route::resource('admin/setting/config','Admin\ConfigController');
		Route::resource('admin/setting/config_group','Admin\ConfigGroupController');
		Route::resource('admin/setting/language','Admin\LanguageController');
		Route::resource('admin/setting/widget','Admin\WidgetController');
		//Category and Content
		Route::resource('admin/cmgr/content','Admin\ContentController');
		Route::resource('admin/content_category','Admin\ContentCategoryController');
		Route::get('admin/contentpage/page_menu','Admin\ContentController@page_menu');
		Route::get('admin/contentpage/pageLoad','Admin\ContentController@pageLoad');
		Route::get('admin/cmgr/filemanager', function(){
			return view('Admin.filemanager.index');
		});


		// Design
		Route::resource('admin/design/banner','Admin\BannerController');
		Route::resource('admin/design/partner','Admin\PartnerController');
		//Content Page
		Route::resource('admin/cmgr/career','Admin\CareerController');
		Route::resource('admin/cmgr/promotions','Admin\PromotionsController');
		Route::resource('admin/cmgr/quick_link','Admin\QuickLinkController');
		Route::resource('admin/cmgr/discover','Admin\DiscoverController');
		Route::resource('admin/cmgr/vision_mission','Admin\VisionMissionController');
		Route::resource('admin/cmgr/where_we_fly','Admin\WhereWeFlyController');
		// Members Management
		Route::resource('admin/members/base_country','Admin\BaseCountryController');
		Route::resource('admin/members/business_type','Admin\BusinessTypeController');
		Route::resource('admin/members/member_type','Admin\MemberTypeController');
		Route::resource('admin/members/position','Admin\PositionController');
		Route::resource('admin/members/member','Admin\MemberController');
		// Event
		Route::resource('admin/event_mgr/event_category','Admin\EventCategoryController');
		Route::resource('admin/event_mgr/event','Admin\EventController');
		Route::get('admin/event_mgr/getSubEvent','Admin\EventController@getSubEvent');
		Route::get('admin/event_mgr/getDataSubEvent','Admin\EventController@getDataSubEvent');
		Route::resource('admin/event_mgr/recent_event','Admin\RecentEventController');
		Route::resource('admin/event_mgr/upcoming_event','Admin\UpcomingEventController');


		Route::resource('admin/link/useful_link','Admin\UsefulLinkController');
		// information
		Route::resource('admin/information/useful_information','Admin\UsefulInformationController');
		//########Activity Log
		Route::get('admin/activity_log','Admin\CommonController@activity_log');

		//########Product Category
		Route::resource('admin/category/product_category','Admin\ProductCategoryController');
		Route::resource('admin/category/product','Admin\ProductController');
		Route::resource('admin/category/product_sub_category','Admin\ProductSubCategoryController');
		
	});

	Route::group(array('middleware' => ['site']), function(){

		//########Client Side
		Route::get('home/category', 'Client\CommonController@category');
		Route::get('/', 'Client\CommonController@index');
		Route::get('/home', 'Client\CommonController@index');

		Route::get('product/getPCCategory', 'Client\CommonController@getPCCategory');
		Route::get('product/getSPCCategory', 'Client\CommonController@getSPCCategory');

		Route::get('product/getSubCategoryDetail', 'Client\CommonController@getSubCategoryDetail');
		
		Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);
		//Authentication routes...
		Route::get('auth/login', 'Auth\AuthController@getLogin');
		Route::post('auth/login', 'Auth\AuthController@postLogin');
		Route::get('auth/logout', 'Auth\AuthController@getLogout');
		Route::get('auth/logoutCashier', 'Auth\AuthCashierController@getLogoutCashier');
		// Registration routes...
		Route::get('auth/register', 'Auth\AuthController@getRegister');
		Route::post('auth/register', 'Auth\AuthController@postRegister');
	});	

