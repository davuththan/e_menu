<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\FMenuRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\FMenuModel;
use App\Models\Admin\MenuType;
use App\Models\Admin\FMenuDescription;
use App\Models\Admin\Language;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class FMenuController extends Controller
{
	
	public $view_title = "Front Menu";
	

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's36';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         $allfmenu = DB::table('fmenu')
                    ->join('menu_type', 'menu_type.id', '=', 'fmenu.menu_type_id')
                    //->join('fmenu_description', 'fmenu_description.fmenu_id', '=', 'fmenu.id')
                    ->select('fmenu.*', 'menu_type.name as menu_type_name')
                    ->orderBy('fmenu.parent_id')
                    ->orderBy('fmenu.id')
                    ->get();
        //dd($allfmenu);
        $data = array();
        foreach ($allfmenu as $menu){
            $id = $menu->id;
            $menu_link = $menu->menu_link;
            $url = $menu->url;
            $ordering = $menu->ordering;
            $is_active = $menu->is_active;
            $manu_type_name = $menu->menu_type_name;

            $parent_id = $menu->parent_id;            
            $parent_name = '';
            if($parent_id>0) $parent_name =  $this->getFmenuDescription('name',$parent_id,CONFIG_LANGUAGE)." -> ";
            $menu_name = $this->getFmenuDescription('name',$id,CONFIG_LANGUAGE);
            //dd($menu_name);
            $data[] = array(
                'id'=>$menu->id,
                'menu_link'=>$menu_link,
                'url'=>$url,
                'ordering'=>$ordering,
                'is_active'=>$is_active,
                'menu_name'=>$parent_name.$menu_name,
                'manu_type_name'=>$manu_type_name
                
                );
        }

        return view('Admin.fmenu.index')->with('allfmenu',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
        $menu_type = MenuType::lists('name','id');
        
        $parentsList = DB::table('fmenu_description')
        ->where('language_id',CONFIG_LANGUAGE)
        ->select('fmenu_id', 'name')
        ->orderBy('name')
        ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            $parents[$pl->fmenu_id] = $pl->name;
        }
       // $languages = Language::lists('name','id','image');
         $languages = Language::all();
		
        return view('Admin.fmenu.create')->with('parents',$parents)
        								->with('languages',$languages)
        								->with('menu_type',$menu_type)
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    // Get Menu Parent
    public function menuParent(Request $request){

        $query = DB::table('fmenu as fm')
                        ->leftjoin('fmenu_description as md','md.fmenu_id','=','fm.id')
                        ->where('md.language_id',CONFIG_LANGUAGE)
                        ->select('fm.*', 'md.name as md_name','md.id as md_id')
                        ->orderBy('md.fmenu_id')
                        ->where('fm.menu_type_id',$request->input('menu_parent'));
                
        // if($request->has('parent_id')){
        //     $query->where('fm.menu_type_id',$request->input('parent_id'));
        // }

        $data=collect($query->get());
        //dd($schedule_mgr);
       // return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FMenuRequest $request)
    {
        
        $input = $request->all();
        if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
        else $input['is_active'] = 0;

        $lastId = DB::table('fmenu')->insertGetId(
             ['menu_type_id' => $input['menu_type_id'], 
                'menu_link' => $input['menu_link'],
                'ordering' => $input['ordering'],
                'is_active' => $input['is_active'],
                'parent_id' => $input['parent_id']
                ]
         );

        //print_r($input['fmenu_language_id'][0]);
        $langLen = sizeof($input['fmenu_language_id']);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['fmenu_language_id'][$i];
            $name = $input['name'][$i];
            $meta_keywords = $input['meta_keywords'][$i];
            $meta_description = $input['meta_description'][$i];
            
            DB::table('fmenu_description')->insert(
                ['name' => $name,
                'fmenu_id' => $lastId,
                'language_id' => $language_id,
                'meta_keywords' => $meta_keywords,
                'meta_description' => $meta_description
                ]
            );

        }
        

        //##########Set Event for ActivityLog############
        $eventName = 'create';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
        	
        return redirect('admin/menu_mgr/fmenu')->with('nmessage','Save Successfully');
        
        
		
    }

   
    public function edit($id)
    {
        
        $menu_type = MenuType::lists('name','id');
        
        $parentsList = DB::table('fmenu_description')
        ->where('language_id',CONFIG_LANGUAGE)
        ->select('fmenu_id', 'name')
        ->orderBy('name')
        ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            //print_r($pl->fmenu_id);
            $parents[$pl->fmenu_id] = $pl->name;
        }
        //dd($parents);
        $languages = Language::all();
        
        $fmenu = FMenuModel::find($id);
        
        $fmenuDes = array();
        foreach ($languages as $lang) {            
            $language_id = $lang->id;
            
            $menu_name = $this->getFmenuDescription('name',$id,$language_id);
            $meta_keywords = $this->getFmenuDescription('meta_keywords',$id,$language_id);
            $meta_description = $this->getFmenuDescription('meta_description',$id,$language_id);
            
            $fmenuDes[$language_id] = array('menu_name'=>$menu_name,
                                'meta_keywords'=>$meta_keywords,
                                'meta_description'=>$meta_description,
                                'language_id'=>$language_id
                            );
        }
        
        return view('Admin.fmenu.edit')->with('parents',$parents)->with('fmenuDes',$fmenuDes)
									        ->with('languages',$languages)
									        ->with('menu_type',$menu_type)
									        ->with('fmenu',$fmenu)
									        ->with('view_title',$this->view_title)
									        ->with('action',"Edition");
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
        else $input['is_active'] = 0;

        $project = FMenuModel::find($id);
        
        $validator1 = Validator::make($input, [
            'menu_type_id' => 'required',
            'menu_link' => 'required'
        ]);
        $langLen = sizeof($input['fmenu_language_id']);
        $validator2 = 1;
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['fmenu_language_id'][$i];
            
            $validator = Validator::make($input, [
                'name_'.$language_id => 'required'                
            ]);
            if($validator->fails()) $validator2 = 0;
        }
        
        if (($validator->fails())||($validator2==0))
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            $project->update($input);

            //update tbl_fmenu_description
            //print_r($input['fmenu_language_id'][0]);
            $langLen = sizeof($input['fmenu_language_id']);
            for($i=0;$i<$langLen;$i++){
                $language_id = $input['fmenu_language_id'][$i];
                $name = $input['name_'.$language_id];
                $meta_keywords = $input['meta_keywords'][$i];
                $meta_description = $input['meta_description'][$i];
                
                DB::table('fmenu_description')->where('fmenu_id', $id)
                    ->where('language_id', $language_id)
                    ->update(
                        ['name' => $name,
                        'meta_keywords' => $meta_keywords,
                        'meta_description' => $meta_description
                        ]
                    );

            }
            //##########Set Event for ActivityLog############
            $eventName = 'update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            return redirect('/admin/menu_mgr/fmenu')->with('message','Save Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //##########Set Event for ActivityLog############
        $eventName = 'delete';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
        //
        $data=UserModel::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
