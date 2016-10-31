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

	//getWidget
	public function getWidget(){

		// $datas = DB::table('widget')
		// 			//->select($field)
		// 			->where('is_active',1)
		// 			//->where('layout_possition',$possition)					
		// 			->get();
		// 			//->toSql();
		
		// $d = array();
		// //dd($datas);
		// //dd(CONFIG_LANGUAGE);
		// foreach ($datas as $data) {
			
		// 	$id = $data->id;
		// 	$is_html = $data->is_html;
		// 	$layout_possition = $data->layout_possition;
		// 	//dd($data->layout_possition);
		// 	$file_name = $data->file_name;
		// 	$name = $this-> getDescription('widget', 'name', $id, CONFIG_LANGUAGE);
		// 	$description = $this-> getDescription('widget', 'description', $id, CONFIG_LANGUAGE);
			
		// 	$d[$layout_possition][] = array('id'=> $id,
		// 					'title'=>$name,
		// 					'is_html'=>$is_html,
		// 					'file_name'=>$file_name,
		// 					'description'=>$description);
		// }
		// return $d;

	}
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

	//get content
	public function getTitleArticle($id, $language_id){
		$results = DB::table('fmenu_description')
		        ->where('language_id',$language_id)
		 		->where('fmenu_id',$id)		
		        ->get();

		 //$data = array();
		 foreach ($results as $key => $value) {
		 	$id = $value->id;
		 	$title_article = $value->name;
		 	$data[] = array('id'=> $id,
		 				'name'=>$title_article
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
