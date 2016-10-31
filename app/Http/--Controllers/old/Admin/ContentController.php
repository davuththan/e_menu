<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Content;
use App\Models\Admin\ContentCategory;
use App\Models\Admin\ContentCategoryDescription;
use App\Models\Admin\Language;
use App\Models\Admin\FMenuModel;
use App\Models\Admin\MenuType;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ContentRequest;
use DB;
use Validator;
use Auth;
use Session;

class ContentController extends Controller
{
    
    public $view_title = "Content";
    

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's42';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        // $query = DB::table('content as c')
        //         ->leftjoin('fmenu_description as fmd','fmd.fmenu_id','=','c.fmenu_id')
        //         ->join('fmenu as fm','fm.id','=','fmd.fmenu_id')
        //         ->leftjoin('fmenu as fms','fms.parent_id','=','fmd.fmenu_id')
        //         ->join('menu_type as mt','mt.id','=','fm.menu_type_id')
        //         ->where('fmd.language_id',CONFIG_LANGUAGE)
        //         ->orderBy('mt.id','DESC')
        //         ->select('fmd.name as fmd_name','mt.name as mt_name','c.is_active as c_active','c.id as cid','fmd.name as fmd_name','fmd.meta_description as fmd_meta_desc','fmd.meta_keywords as fmd_meta_key')
        //         ->get();

        $allfmenu = DB::table('content as c')
                    ->join('fmenu as f','c.fmenu_id','=','f.id')
                    ->join('menu_type as mt', 'mt.id', '=', 'c.menu_type_id')
                    ->select('f.*','mt.name as menu_type_name','c.id as cid')
                    ->orderBy('f.parent_id')
                    ->orderBy('mt.id')
                    ->get();
        //dd($allfmenu);
        $alldata = array();
        foreach ($allfmenu as $menu){
            $id = $menu->id;
            $menu_link = $menu->menu_link;
            $url = $menu->url;
            $ordering = $menu->ordering;
            $is_active = $menu->is_active;
            $menu_type_name = $menu->menu_type_name;

            $parent_id = $menu->parent_id;            
            $parent_name = '';
            if($parent_id>0) $parent_name =  $this->getFmenuDescription('name',$parent_id,CONFIG_LANGUAGE)." -> ";
            $menu_name = $this->getFmenuDescription('name',$id,CONFIG_LANGUAGE);
            //dd($menu_name);
            $alldata[] = array(
                'id'=>$menu->id,
                'cid'=>$menu->cid,
                'menu_link'=>$menu_link,
                'url'=>$url,
                'ordering'=>$ordering,
                'is_active'=>$is_active,
                'menu_name'=>$parent_name.$menu_name,    
                'menu_type_name'=>$menu_type_name
            );

            //dd($alldata);
        }

        //dd($allfmenu);
        return view('Admin.content.index')->with('allfmenu',$alldata);
    }

    // Get Menu Parent
    public function page_menu(Request $request){

        $fmenuid='';
        $list_content = DB::table('content')->get();

        foreach ($list_content as $key => $value) {
            $fmenuid .= $value->fmenu_id.":";
        }

        $fmenu_id_arr = explode(":", $fmenuid);

        $query = DB::table('fmenu as fm')
                        ->leftjoin('fmenu_description as md','md.fmenu_id','=','fm.id')
                        ->where('md.language_id',CONFIG_LANGUAGE)
                        //->whereNotIn('fm.id',$fmenu_id_arr)
                        ->select('fm.*', 'md.name as md_name','md.id as md_id')
                        ->orderBy('md.fmenu_id');
        
        $query->where('fm.menu_type_id',$request->input('menu_parent'));
   
        $data = collect($query->get());
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();

        $category = DB::table('fmenu as fm')
                        ->leftjoin('fmenu_description as fmd','fm.id','=','fmd.fmenu_id')
                        ->where('fmd.language_id',CONFIG_LANGUAGE)
                        ->where('fm.menu_type_id',2)
                        ->select('fmd.name as fmd_name','fmd.fmenu_id as fmd_id')
                        ->orderBy('fmd.name')
                        ->get();


        $menutype = MenuType::lists('name','id');
        //$menutype = MenuType::all();
        //dd($menutype);
        return view('Admin.content.create') ->with('category',$category)
                                            ->with('languages',$languages)
                                            ->with('menutype',$menutype)
                                            ->with('view_title',$this->view_title)
                                            ->with('action',"Create");
    }


    public function pageLoad(Request $request){
       
        $query = DB::table('fmenu as fm')
                        ->leftjoin('fmenu_description as md','md.fmenu_id','=','fm.id')
                        ->where('md.language_id',CONFIG_LANGUAGE)
                        ->select('fm.*', 'md.name as md_name','md.id as md_id')
                        ->orderBy('md.fmenu_id')
                        ->where('fm.menu_type_id',$request->input('menu_parent'));
                
        $data=collect($query->get());
        //dd($schedule_mgr);
        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //echo $data;
        $input = $request->all();

        // setting up rules
        $rules = array('menu_type_id'=>'required','fmenu_id' => 'required',''); 
        $messages = [
           'menu_type_id.required' => 'Menu Type is required!',
           'fmenu_id.required' => 'Page is required!',
       ];
       
        $validator = Validator::make($input,$rules,$messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }else{

            $content = new Content(array(
                'ordering' => $request->input('ordering'),
                'is_active'  => $request->input('is_active'),
                'fmenu_id' => $request->input('fmenu_id'),
                'menu_type_id' => $request->input('menu_type_id')
            ));
            $content->save();
            $lastId = $content->id;
            $langLen = sizeof($input['_language_id']);

            for($i=0;$i<$langLen;$i++){
                $language_id = $input['_language_id'][$i];
                //$name = $input['name_'.$language_id];
                $description = $input['description_'.$language_id];
                $meta_keywords = $input['meta_keywords'][$i];
                $meta_description = $input['meta_description'][$i];
                DB::table('content_description')->insert(
                    [
                    'content_id' => $lastId,
                    'language_id' => $language_id,
                    'description' => $description,
                    'meta_description' => $meta_description,
                    'meta_keywords' => $meta_keywords
                    ]
                );
            }

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/cmgr/content')->with('message','Save Successfully');
        }

    }

    public function show($id)
    {   
        $menu_type_id = DB::table('content')->where('id', $id)->pluck('menu_type_id');
        $fmenu_id = DB::table('content')->where('id', $id)->pluck('fmenu_id');

        //$all = FMenuModel::lists('name');
        $page_menu = DB::table('fmenu as fm')
               ->join('fmenu_description as fmd','fmd.fmenu_id','=','fm.id')
               ->where('fm.menu_type_id',$menu_type_id)
               ->where('fmd.language_id',CONFIG_LANGUAGE)
               ->select('fmd.*','fmd.fmenu_id as f_fmenu_id','fmd.name as f_name')
               ->get();

        //dd($sql);

        $content = Content::find($id); 
        // dd($content);

        $category = DB::table('content as c')
                        ->leftjoin('content_description as cd','c.id','=','cd.content_id')
                        ->where('c.id',$id)
                        ->select('c.id as cid','c.fmenu_id as cfid','c.menu_type_id as cmid','cd.language_id as cd_langID','c.id as cid','cd.description as cd_description')
                        ->get();

        //dd($category);
        //dd($category);
        $languages = Language::all();                
        $menutype = MenuType::lists('name','id');
        

        $category = array();
        foreach ($category as $pl) {
            $category[$pl->content_category_id] = $pl->name;
        }

        $languages = Language::all();  
        $data = Content::find($id);

        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            
            $description = $this->getDescription('content','description',$id,$language_id);
            $meta_keywords = $this->getDescription('content','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('content','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
                'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
            //dd($dataDes);
        }

        return view('Admin.content.view')->with('languages',$languages)
                                         ->with('content',$content)
                                         ->with('page_menu',$page_menu)
                                         ->with('dataDes',$dataDes)
                                         ->with('fmenu_id',$fmenu_id)
                                         ->with('category',$category)
                                         ->with('view_title',$this->view_title)
                                         ->with('menutype',$menutype)
                                         ->with('action',"Edition");
    }

    public function edit($id)
    {   
        $menu_type_id = DB::table('content')->where('id', $id)->pluck('menu_type_id');
        $fmenu_id = DB::table('content')->where('id', $id)->pluck('fmenu_id');

        //$all = FMenuModel::lists('name');
        $page_menu = DB::table('fmenu as fm')
               ->join('fmenu_description as fmd','fmd.fmenu_id','=','fm.id')
               ->where('fm.menu_type_id',$menu_type_id)
               ->where('fmd.language_id',CONFIG_LANGUAGE)
               ->select('fmd.*','fmd.fmenu_id as f_fmenu_id','fmd.name as f_name')
               ->get();

        //dd($sql);

        $content = Content::find($id); 
        // dd($content);

        $category = DB::table('content as c')
                        ->leftjoin('content_description as cd','c.id','=','cd.content_id')
                        ->where('c.id',$id)
                        ->select('c.id as cid','c.fmenu_id as cfid','c.menu_type_id as cmid','cd.language_id as cd_langID','c.id as cid','cd.description as cd_description')
                        ->get();

        //dd($category);
        //dd($category);
        $languages = Language::all();                
        $menutype = MenuType::lists('name','id');
        

        $category = array();
        foreach ($category as $pl) {
            $category[$pl->content_category_id] = $pl->name;
        }

        $languages = Language::all();  
        $data = Content::find($id);

        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            
            $description = $this->getDescription('content','description',$id,$language_id);
            $meta_keywords = $this->getDescription('content','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('content','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
                'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
            //dd($dataDes);
        }

        return view('Admin.content.edit')->with('languages',$languages)
                                         ->with('content',$content)
                                         ->with('page_menu',$page_menu)
                                         ->with('dataDes',$dataDes)
                                         ->with('fmenu_id',$fmenu_id)
                                         ->with('category',$category)
                                         ->with('view_title',$this->view_title)
                                         ->with('menutype',$menutype)
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
        if(!$request->has('is_active')){
            $request->offsetSet('is_active','0');
        }

        $input = $request->all();
        //dd($input);
        $project = Content::find($id);        
        
        $langLen = sizeof($input['_language_id']);
        
        // setting up rules
        $rules = array('menu_type_id'=>'required','fmenu_id' => 'required',''); 
        $messages = [
           'menu_type_id.required' => 'Menu Type is required!',
           'fmenu_id.required' => 'Page is required!',
       ];

        $validator = Validator::make($input,$rules,$messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
            //return redirect('admin/cmgr/content/create')->withErrors($validator);
        }else{

            $project->update($input);

            $langLen = sizeof($input['_language_id']);

            for($i=0;$i<$langLen;$i++){
                $language_id = $input['_language_id'][$i];
                //$name = $input['name_'.$language_id];
                $description = $input['description_'.$language_id];
                $meta_keywords = $input['meta_keywords'][$i];
                $meta_description = $input['meta_description'][$i];
                DB::table('content_description')->where('content_id', $id)
                    ->where('language_id', $language_id)
                    ->update(
                        [
                        'description' => $description,
                        'meta_keywords' => $meta_keywords,
                        'meta_description' => $meta_description
                        ]
                    );
            }
           // dd($project);
            
            //##########Set Event for ActivityLog############
            $eventName = 'update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            return redirect('/admin/cmgr/content')->with('message','Update Successfully');
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
        $data=Content::find($id)->delete();
        
        //delete from table content_description
        DB::table('content_description')->where('content_id', $id)->delete();

        return redirect()->back()->with('message','Deleted successfully');
    }

}
