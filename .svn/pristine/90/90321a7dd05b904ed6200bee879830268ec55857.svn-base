<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	View::composer('bo.common.sidebar', function($view){
    		
    		$query = \DB::table('group_role_detail')
    				->join('group_user','group_user.id','=','group_role_detail.group_role_id')
    				->join('menu','menu.id','=','group_role_detail.menu_id')
    				->join('user','user.group_id','=','group_user.id')
    				->where('user.id',Auth::user()->id)
    				->orderBy('menu.order_level')
    				->select('menu.*');
    		$data = collect($query->get());
    		$menuList = $data->groupBy('parent_id');
    		$view->with('menuList', $menuList);
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
