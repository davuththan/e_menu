<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Carbon\Carbon;
use Input;
use App\Models\Activity;
use App\Models\Config\Menu;
use Auth;
use Request as R;
use Session;

abstract class Controller extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getMenuList(){
    	$menuList = "";
    	return $menuList;
    }

    // get
    public function DisplayLangByCat(){
    	$menuList = "";
    	return $menuList;
    }

    //getDescription
    public function getDescription($table, $field, $id, $language_id){
        
        $name = DB::table($table.'_description')
                ->select($field)
                ->where('language_id',$language_id)
                ->where($table.'_id',$id)       
                ->get();
        //->toSql();
        // dd($language_id);
        // dd($name);
        if(empty($name)) $data = '';
        else $data = $name[0]->$field;
        return $data;
    }

    //getFmenuDescription
    public function getFmenuDescription($field, $fmenu_id, $language_id){
        $name = DB::table('fmenu_description')
        ->select($field)
        ->where('fmenu_id',$fmenu_id)
        ->where('language_id',$language_id)
        ->get();
        //->toSql();
        // return $name[0]->$field;
         if(empty($name)) $data = '';
        else $data = $name[0]->$field;
        return $data;
    }
    
    public function activityLog($actionName){
    	$activity = array(
    			'user_id' => Auth::user()->id,
    			'action' => $actionName,
    			'menu_code' => $this->getMenuCode(),
    			'created_at' => Carbon::now()
    	);
    	Activity::create($activity);
    }
    
    private function getMenuCode(){
    	return Session::get('menuCode');
    }
    
    public function getMenu(){
    	$uri = strtok($_SERVER["REQUEST_URI"],'?');
    	$menu = Menu::where('url',$uri)
    	 ->first();
    	 if($menu != null ){
    	 return $menu->menu_code;
    	 }
    	 return "error";
    }
    //
}
