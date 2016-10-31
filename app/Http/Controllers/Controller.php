<?php 
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Admin\FMenuDescrption;
//use App\Models\Admin\Currency;
use DB;
use Session;
use Auth;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	//get FMenuLists
	public function getFMenuLists($language_id,$menu_type,$parent_id=0){

		$fmenu = DB::table('fmenu')
					//->select($field)
					->where('is_active',1)
					->where('parent_id',$parent_id)
					->where('menu_type_id',$menu_type)
					->orderBy('ordering')
					->get();
					//->toSql();
		//dd($fmenu);
		$data = array();
		foreach ($fmenu as $fm) {
			//dd($fm);
			$id = $fm->id;
			$url = $fm->url;
			$fa_icon = $fm->fa_icon;

			$child = $this -> getFMenuLists($language_id,$menu_type,$id);
			//dd($child);
			$name = $this-> getDescription('fmenu', 'name', $id, $language_id);
			$checkLink = explode('http:', $fm->menu_link);
			if(sizeof($checkLink)>1) $menu_link = $fm->menu_link;
			//else $menu_link = SITE_HTTP_URL.$fm->menu_link;
			else $menu_link = $fm->menu_link;
			$data[] = array('id'=> $id,
							'name'=>$name,
							'url'=>$url,
							'fa_icon' => $fa_icon,
							'link'=>$menu_link,
							'parent_id'=>$fm->parent_id,
							'child'=>$child);

			//dd($data);
		}
		return $data;

	}

	// Permission
	public function permissionOnMenu($group_id,$language_id){
		$menu_arr="";
	  $menu_id_arr="";
	  $menu_parent_id_arr="";
	  $global_menu = "";
	  // $group_id = $GroupRole->id;
	  $group_role_detail_arr=array();
	  $group_role_detail = DB::table('group_role_detail')
	          ->where('group_role_id','=',$group_id)
	          ->get();

	  foreach ($group_role_detail as $key => $value){
		$menu_arr .= $value->menu_code.":";
		$menu_id_arr .= $value->menu_id.":";
		$menu_parent_id_arr .= $value->parent_menu_id.":";

		$group_role_detail_arr[] = array(
			'menu_code'=>$menu_arr,
			'menu_id'=>$menu_id_arr,
			'menu_parent_id'=>$menu_parent_id_arr,
		);
	  }

	  $menu_sep = explode(':',$menu_arr);
	  $menu_id_sep = explode(':',$menu_id_arr);
	  $menu_parent_id_sep = explode(':',$menu_parent_id_arr);
	  // print_r($menu_sep);
	  $parents_menu_arr = array();
	  // parent_menu #########
	  $parents_menu = DB::table("menu as m")
	      ->JOIN('menu_description as md','m.id','=','md.menu_id')
	      ->WHERE('m.parent_id',0)
	      ->WHERE('md.language_id',$language_id)
	      ->SELECT('m.id as id','m.parent_id as parent_id','m.default as default','m.menu_code as menu_code','m.fa_icon as fa_icon','m.menu_link as p_menu_link','md.name as parent_menu_name','m.id as parent_menu_id')
	      ->OrderBy('m.ordering')
	      ->get();

	  foreach ($parents_menu as $parent_menu) 
	  {
	    $mm_id='';
	    $mmcode='';
	    $mparent_id='';
	    $read='';
	    $write='';
	    $mtitle = $parent_menu->parent_menu_name;
	    $mcode = $parent_menu->menu_code;
	    $mparent_id = $parent_menu->parent_id;
	    $mid = $parent_menu->id;
	    $default = $parent_menu->default;
	    // dd($mcode);
	    if(in_array($mcode, $menu_sep)){
			$mm_id = $parent_menu->id;
			$mmcode = $parent_menu->menu_code;
	    }

	    $read='';
	    $write='';
	    $reads = DB::table('group_role_detail')
	                ->where('menu_code',$mcode)
	                ->where('group_role_id',$group_id)
	                ->get();
				foreach ($reads as $read12){
					$read = $read12->read;
				}

				$writes = DB::table('group_role_detail')->where('menu_code','=',$mcode)->where('group_role_id','=',$group_id)->get();
				foreach ($writes as $writes12){
					$write = $writes12->write;
				}

	    // Submenu ############
	    $submenus = DB::table("menu as m")
		    ->JOIN('menu_description as md','m.id','=','md.menu_id')
		    ->WHERE('m.parent_id',$mid)
		    ->WHERE('md.language_id',$language_id)
		    ->SELECT('m.id as id','m.parent_id as parent_id','m.menu_code as menu_code','m.fa_icon as fa_icon','m.menu_link as p_menu_link','md.name as parent_menu_name','m.id as parent_menu_id')
		    ->OrderBy('m.ordering')
		    ->get();
	    
	    	$submenus_arr=array();
				//foreach ($submenu as $submenus) {
				foreach ($submenus as $submenu) {
				  $s_id='';
				  $s_code='';
				  $sread='';
				  $swrite='';
				  $s_parent_id='';

				  $sid = $submenu->id;
				  $smtitle = $submenu->parent_menu_name;
				  $smcode = $submenu->menu_code;
				  $sparent_id = $submenu->parent_id;
				    
				  if(in_array($smcode, $menu_sep)){
				      // $s_id = $submenu->id;
				      // $s_code = $submenu->menu_code;
				      // $s_parent_id = $submenu->parent_id;
						$sub_reads = DB::table('group_role_detail')->where('menu_code','=',$smcode)->where('group_role_id','=',$group_id)->get();
						foreach ($sub_reads as $sub_read){
				      $sread = $sub_read->read;
				    }
				      
				    $sub_writes = DB::table('group_role_detail')->where('menu_code','=',$smcode)->where('group_role_id','=',$group_id)->get();
				    foreach ($sub_writes as $sub_write){
				      $swrite = $sub_write->write;
				    }
				  }

				  //sreyleak add on more sub menu
					$sub_submenus_arr = array();
					$sub_submenus = DB::table("menu as m")
								    ->JOIN('menu_description as md','m.id','=','md.menu_id')
								    ->WHERE('m.parent_id',$sid)
								    ->WHERE('md.language_id',$language_id)
								    ->SELECT('m.id as id','m.parent_id as parent_id','m.menu_code as menu_code','m.fa_icon as fa_icon','m.menu_link as p_menu_link','md.name as parent_menu_name','m.id as parent_menu_id')
								    ->OrderBy('m.ordering')
								    ->get();			    
		    	
					foreach ($sub_submenus as $sub_submenu) {
					  $sub_s_id='';
					  $sub_s_code='';
					  $sub_sread='';
					  $sub_swrite='';
					  $sub_s_parent_id='';

					  $sub_sid = $sub_submenu->id;
					  $sub_smtitle = $sub_submenu->parent_menu_name;
					  $sub_smcode = $sub_submenu->menu_code;
					  $sub_sparent_id = $sub_submenu->parent_id;
					    
					  if(in_array($sub_smcode, $menu_sep)){
							$sub_reads = DB::table('group_role_detail')->where('menu_code','=',$smcode)->where('group_role_id','=',$group_id)->get();
							foreach ($sub_reads as $sub_read){
					      $sub_sread = $sub_read->read;
					    }
					      
					    $sub_writes = DB::table('group_role_detail')->where('menu_code','=',$smcode)->where('group_role_id','=',$group_id)->get();
					    foreach ($sub_writes as $sub_write){
					      $sub_swrite = $sub_write->write;
					    }
					  }

						$sub_submenus_arr[]=array(
					    's_menu_name'=>$sub_smtitle,
							's_menu_code'=>$sub_smcode,
							's_parent_id'=>$sid,
							's_mid'=>$sub_sid,
							's_read'=>$sub_sread,
							's_write'=>$sub_swrite,
							'sub_menus'=>$sub_submenus_arr,
					    );
					}
				  //end
				  $submenus_arr[]=array(
				    's_menu_name'=>$smtitle,
						's_menu_code'=>$smcode,
						's_parent_id'=>$sparent_id,
						's_mid'=>$sid,
						's_read'=>$sread,
						's_write'=>$swrite,
						'sub_menus'=>$sub_submenus_arr,
				    );
				}

		$parents_menu_arr[] = array(
			'parent_menu_name'=>$mtitle,
			'menu_code'=>$mcode,
			'default'=>$default,
			'parent_id'=>$mparent_id,
			'mid'=>$mid,
			'read'=>$read,
			'write'=>$write,
			'sub_menus'=>$submenus_arr,
		);
	}

	$global_menu[] = array(
		'group_role_detail_arr'=>$group_role_detail_arr,
		'parents_menu_arr'=>$parents_menu_arr,
	);

	// dd($global_menu);			

	return($global_menu);
	}

	//get content
	public function getContent($id, $language_id){

		$results = DB::table('content as c')
					->leftjoin('fmenu_description as fmd','c.fmenu_id','=','fmd.fmenu_id')
					->join('content_description as cd','cd.content_id','=','c.id')
					->select('c.id as id','fmd.name as name','cd.description as cd_description','cd.language_id as cd_language')
					->where('c.is_active',1)
					->where('fmd.language_id',$language_id)
					->where('c.fmenu_id',$id)					
					->get();

		$data = array();

		foreach ($results as $result) {
			$id = $result->id;
			$title_content = $result->name;
			$name = $this-> getDescription('content', 'description', $id, $language_id);
			$description =  html_entity_decode($this-> getDescription('content', 'description', $id, $language_id));
			$data[] = array('id'=> $id,
							'name'=>$title_content,
							'description'=>$description
						   );

		}
		return $data;
	}

	//getDescription
	public function getDescription($table, $field, $id, $language_id){
		
		$name = DB::table($table.'_description')
		        ->select($field)
		        ->where('language_id',$language_id)
		 		->where($table.'_id',$id)		
		        ->get();
        //->toSql();
        //dd($language_id);
        //dd($name);
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
		return $name[0]->$field;
	}
	
	
	public function getCurrency($name){
		$id = Currency::where('name',$name)->first()->id;
		return $id;
	}

	public function DateNow(){
		$datetime = date('Y-m-d H:i:s');
		return $datetime;
	}

	public function ConvertDate($datetime){
		$datetime = strtotime($datetime);
		$newdate = date('Y-m-d H:i:s',$datetime);
		return $newdate;
	}

	public function FormatDate($datetime){
		$datetime = strtotime($datetime);
		$newdate = date(FORMAT_DATE,$datetime);
		return $newdate;
	}
	
	//Activity Log
    public function ActivityLog(){
		DB::table('activity_log')->insert(
		    [
		    	'user_id' => Auth::user()->id, 
		    	'action' => Session::get('eventName'),
		    	'menu_code' => Session::get('permissionOn_Menu_ID'),
		    	'created_at' => date('Y-m-d h:i:s')
		    ]
		);	
    }

}
