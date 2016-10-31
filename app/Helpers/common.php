<?php 
	namespace App\Helpers;

	use App\Http\Controllers\Controller;
	use App\Models\Admin\Langugae;
	use Carbon\Carbon;
	use DB;
	use Validator;
	use Auth;
	use Session;
	use Helpers;
	class common{ 
		// getMenu
		
		public static function getMenus($language_id=1,$menu_type_id=1){
			$menu = array();
			  $Group_ID = Auth::user()->group_id;
			  $parent_menus = DB::table("group_role as gr")
			  				->JOIN('group_role_detail as grd', 'grd.group_role_id', '=', 'gr.id')
							->JOIN('menu as m','m.menu_code','=','grd.menu_code')
							->JOIN('menu_description as md','m.id','=','md.menu_id')
							->WHERE('m.is_active',1)
							->WHERE('gr.group_id','=',$Group_ID)
							->WHERE('m.parent_id',0)
							->WHERE('m.menu_type_id',$menu_type_id)
							->WHERE('md.language_id',$language_id)

							->SELECT('grd.menu_id as groupMenu_id','gr.id as grouRole_id','m.fa_icon as fa_icon','m.default as default','m.menu_link as p_menu_link','m.menu_code as menu_code','md.name as parent_menu_name','m.id as parent_menu_id')
							->OrderBy('m.ordering')
							->get(); 

			  foreach ($parent_menus as $parent_menu) {
			  	 $groupMenu_id = $parent_menu->groupMenu_id;
            	 $grouRole_id = $parent_menu->grouRole_id;

				$children_menu = array();
				$children = DB::table("menu as m")
							->JOIN('menu_description as md','m.id','=','md.menu_id')
							->JOIN('group_role_detail as grd','grd.menu_id','=','m.id')
							->WHERE('m.is_active',1)
							->WHERE('grd.group_role_id','=',$grouRole_id)
							->WHERE('m.parent_id','=',$groupMenu_id)
							->WHERE('m.parent_id','>',0)
							->WHERE('m.parent_id',$parent_menu->parent_menu_id)
							->WHERE('md.language_id',$language_id)
							->SELECT('m.menu_code as menu_code','m.menu_link as c_menu_link','md.name as child_menu_name')
							->OrderBy('m.ordering')
							->get(); 

				foreach ($children as $child) {
					$children_menu[] = array(
						'child_menu_name' => $child->child_menu_name,
						'c_menu_link' => $child->c_menu_link,
						'menu_code' => $child->menu_code,
					);
				}

				$menu[] = array(
					'parent_menu_name' => $parent_menu->parent_menu_name,
					'fa_icon' => $parent_menu->fa_icon,
					'default' => $parent_menu->default,
					'menu_code' => $parent_menu->menu_code,
					'p_menu_link' => $parent_menu->p_menu_link,
					'children_menu' => $children_menu
				);
			}
			// dd($menu);
			return $menu;
		}


		public static function getLanguage(){
			$languages = DB::table('language')->get();
			return $languages;
		}

		public static function getListContact(){
			$list_contact = DB::table('config')
                          ->Where('config_group_id',6)
                          ->get();

            return $list_send_mails;
		}

		public static function getListSendMail(){
			$list_send_mails = DB::table('config')
                          ->Where('config_group_id',6)
                          ->get();

            return $list_send_mails;
		}

		public static function getMenu(){
			if(Session::get('applangId')){
				$language_id = Session::get('applangId');
			}else{
				$language_id = CONFIG_LANGUAGE;
			}

			$catMenus = DB::table('fmenu_description as fd')
			            ->Join('fmenu as f','f.id','=','fd.fmenu_id')
			            ->Where('fd.language_id',$language_id)
			            ->Where('parent_id',0)
			            ->Select('fd.*','f.id','f.url')
			            ->orderBy('f.ordering','ASC')
			            ->get();
			$Menu_arr = array();
			foreach ($catMenus as $catMenu) {
			  $catMenu_Id = $catMenu->id;

			  $child_Menus = DB::table('fmenu_description as fd')
			                ->Join('fmenu as f','f.id','=','fd.fmenu_id')
			                ->Where('parent_id',$catMenu_Id)
			                ->Select('fd.*','f.id','f.url')
			                ->orderBy('f.ordering','ASC')
			                ->get();
			  
			  $child_Menu_arry = array();
			  foreach ($child_Menus as $child_Menu) {
			    $child_Menu_arry[] = array(
			      'id' => $child_Menu->id,
			      'name' => $child_Menu->name,
			      'url' => $child_Menu->url,
			    );
			  }

			  $Menu_arr[] = array(
			    'id' => $catMenu->id,
			    'name' => $catMenu->name,
			    'url' => $catMenu->url,
			    'child_Menu' => $child_Menu_arry
			  );
			}

			return $Menu_arr;
		}

		public static function getInformatoin(){
			if(Session::get('applangId')){
			  $language_id = Session::get('applangId');
			}else{
			  $language_id = CONFIG_LANGUAGE;
			}

			$get_records = DB::table('information_description as id')
			              ->Join('information as i','id.information_id','=','i.id')
			              ->Select('id.*','i.id as id')
			              ->Where('id.language_id',$language_id)
			              ->get();

			$data_arr = array();
			foreach ($get_records as $get_record) {
			  $data_arr[] = array(
			      'id' => $get_record->id,
			      'name' => $get_record->name,
			      'description' => $get_record->description,
			  );
			}

			return $data_arr;

		}


		public static function getBanners(){
			$banners = DB::table('banner')->get();
			return $banners;
		}

		public static function getSocial(){
			$socials = DB::table('config')->Where('config_group_id',5)->get();
			return $socials;
		}

		public static function getPartners(){
			$banners = DB::table('partner')->OrderBy('order_level','ASC')->get();
			return $banners;
		}

		public static function FormatDate($date){
			$d= strtotime($date);
			$newdate = date(FORMAT_DATE,$d);
			return $newdate;
		}

	}

?>