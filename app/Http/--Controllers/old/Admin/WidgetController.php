<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Widget;
use App\Models\Admin\WidgetDescription;
use App\Models\Admin\LayoutPossition;
use App\Models\Admin\Language;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class WidgetController extends Controller
{
    
    public $view_title = "Widget";
    

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's45';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $alldata = DB::table('widget')            
            ->orderBy('widget.layout_possition', 'desc')
            ->get();
            //->toSql(); 
            //dd($alldata);

        $datas = array();
        foreach ($alldata as $data){
            $id = $data->id;            
            $is_active = $data->is_active;
            $ordering = $data->ordering;
            $name =  $this->getDescription('widget','name',$id,CONFIG_LANGUAGE);
            $description = $this->getDescription('widget', 'description', $id, CONFIG_LANGUAGE);
            
            $datas[] = array(
                'id'=>$id,
                'layout_possition'=>$data->layout_possition,
                'is_html'=>$data->is_html,
                'file_name'=>$data->file_name,
                'is_active'=>$is_active,
                'ordering'=>$ordering,
                'description'=>$description,
                'name'=>$name
                );
        }

        return view('Admin.widget.index')->with('alldata',$datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
                
    }

    public function show($id)
    {
       
        $alldata = DB::table('widget')            
            ->orderBy('widget.layout_possition', 'desc')
            ->get();
            //->toSql(); 
            //dd($alldata);

        $datas = array();
        foreach ($alldata as $data){
            $id = $data->id;            
            $is_active = $data->is_active;
            $ordering = $data->ordering;
            $name =  $this->getDescription('widget','name',$id,CONFIG_LANGUAGE);
            $description = $this->getDescription('widget', 'description', $id, CONFIG_LANGUAGE);
            
            $datas[] = array(
                'id'=>$id,
                'layout_possition'=>$data->layout_possition,
                'is_html'=>$data->is_html,
                'file_name'=>$data->file_name,
                'is_active'=>$is_active,
                'ordering'=>$ordering,
                'description'=>$description,
                'name'=>$name
                );
        }
        return view('admin.content.view')->with('category',$category)
                                            ->with('dataDes',$dataDes)
                                            ->with('languages',$languages)
                                            ->with('data',$data)
                                            ->with('view_title',$this->view_title)
                                            ->with('action',"View");
    }

    public function edit($id)
    {
            
        $LayoutPossition = LayoutPossition::lists('name','keywords');

        $languages = Language::all();
        
        $alldata = Widget::findOrFail($id);
        
        $dataDes = array();
        foreach ($languages as $lang) {            
            $language_id = $lang->id;
            $description = $this->getDescription('widget','description',$id,$language_id);
            $name = $this->getDescription('widget','name',$id,$language_id);
            
            $dataDes[$language_id] = array('name'=>$name,
                                'description' => $description,
                                'language_id'=>$language_id
                            );
        }
        //dd($dataDes);
        return view('Admin.widget.edit')->with('LayoutPossition',$LayoutPossition)
                                            ->with('dataDes',$dataDes)
                                            ->with('languages',$languages)
                                            ->with('data',$alldata)
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

        if(isset($input['is_html'])&&($input['is_html']=='on')) $input['is_html'] = 1;
        else $input['is_html'] = 0;

        if(isset($input['display_title'])&&($input['display_title']=='on')) $input['display_title'] = 1;
        else $input['display_title'] = 0;
        //dd($input);
        $project = Widget::find($id);        
        
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
                $description = $input['description_'.$language_id];
               
                
                DB::table('content_description')->where('content_id', $id)
                    ->where('language_id', $language_id)
                    ->update(
                        ['name' => $name,
                        'description' => $description
                        ]
                    );

            }

            
            //##########Set Event for ActivityLog############
            $eventName = 'update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            return redirect('/admin/widget')->with('message','Save Successfully');
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
