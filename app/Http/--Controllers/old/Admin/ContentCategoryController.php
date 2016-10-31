<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContentCategory;
use App\Models\Admin\ContentCategoryDescription;
use App\Models\Admin\Language;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class ContentCategoryController extends Controller
{
	
	public $view_title = "Content Category";
	

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's41';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $alldata = DB::table('content_category')
            ->orderBy('content_category.id', 'desc')
            ->get();
            //->toSql(); 
            //dd($alldata);

        $datas = array();
        foreach ($alldata as $data){
            $id = $data->id;
            $is_active = $data->is_active;
            $ordering = $data->ordering;
            $image = $data->image;

            $parent_id = $data->parent_id;            
            $parent_name = '';
            if($parent_id>0) $parent_name =  $this->getDescription('content_category','name',$parent_id,CONFIG_LANGUAGE);
            $name = $this->getDescription('content_category', 'name', $id, CONFIG_LANGUAGE);
            //dd($menu_name);
            $datas[] = array(
                'id'=>$id,
                'is_active'=>$is_active,
                'ordering'=>$ordering,
                'image'=>$image,
                'parent_name'=>$parent_name,
                'name'=>$name
                );
        }

        return view('Admin.content_category.index')->with('alldata',$datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
        $parentsList = DB::table('content_category_description')
        ->where('language_id',CONFIG_LANGUAGE)
        ->select('content_category_id', 'name')
        ->orderBy('name')
        ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            $parents[$pl->content_category_id] = $pl->name;
        }
        //dd($parents);
       
       
        $languages = Language::all();
		
        return view('Admin.content_category.create')->with('parents',$parents)
        								->with('languages',$languages)
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        
        $input = $request->all();
        
        if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
        else $input['is_active'] = 0;
        //dd($input);
        $lastId = DB::table('content_category')->insertGetId( 
                    ['ordering' => $input['ordering'],
                    'is_active' => $input['is_active'],
                    'parent_id' => $input['parent_id'],
                    'image' => $input['image']
                    ]
                  );

        $langLen = sizeof($input['_language_id']);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['_language_id'][$i];
            $name = $input['name'][$i];
            $meta_keywords = $input['meta_keywords'][$i];
            $meta_description = $input['meta_description'][$i];
            
            DB::table('content_category_description')->insert(
                ['name' => $name,
                'content_category_id' => $lastId,
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
        	
        return redirect('admin/content_category')->with('nmessage','Save Successfully');
	
    }

    public function edit($id)
    {
            
        $parentsList = DB::table('content_category_description')
        ->where('language_id',CONFIG_LANGUAGE)
        ->select('content_category_id', 'name')
        ->orderBy('name')
        ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            $parents[$pl->content_category_id] = $pl->name;
        }

        $languages = Language::all();
        
        $data = ContentCategory::find($id);
        
        $dataDes = array();
        foreach ($languages as $lang) {            
            $language_id = $lang->id;
            
            $name = $this->getDescription('content_category','name',$id,$language_id);
            $meta_keywords = $this->getDescription('content_category','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('content_category','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array('name'=>$name,
                                'meta_keywords'=>$meta_keywords,
                                'meta_description'=>$meta_description,
                                'language_id'=>$language_id
                            );
        }
        
        return view('Admin.content_category.edit')->with('parents',$parents)
                                            ->with('dataDes',$dataDes)
									        ->with('languages',$languages)
									        ->with('data',$data)
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
        //dd($input);
        $project = ContentCategory::find($id);        
        
        $langLen = sizeof($input['_language_id']);
        $validator2 = 1;
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['_language_id'][$i];
            
            $validator = Validator::make($input, [
                'name_'.$language_id => 'required'                
            ]);
            if($validator->fails()) $validator2 = 0;
        }
        
        if($validator2==0)
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            $project->update($input);

            $langLen = sizeof($input['_language_id']);
            for($i=0;$i<$langLen;$i++){
                $language_id = $input['_language_id'][$i];
                $name = $input['name_'.$language_id];
                $meta_keywords = $input['meta_keywords'][$i];
                $meta_description = $input['meta_description'][$i];
                
                DB::table('content_category_description')->where('content_category_id', $id)
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

            return redirect('/admin/content_category')->with('message','Save Successfully');
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
        $data=ContentCategory::find($id)->delete();
        
        //delete from table content_category_description
        DB::table('content_category_description')->where('content_category_id', $id)->delete();

        return redirect()->back()->with('message','Deleted successfully');
    }

}
