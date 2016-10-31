<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Language;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class LanguageController extends Controller
{
    
    public $view_title = "Language";
    

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's44';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $alldata = DB::table('language')
            ->orderBy('language.id', 'desc')
            ->get();
            //->toSql(); 
            //dd($alldata);

        return view('Admin.language.index')->with('alldata',$alldata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
               
        return view('Admin.language.create')->with('view_title',$this->view_title)
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
          
        $validator = Validator::make($input, [
                'code' => 'required|max:3|unique:language',
                'name' => 'required'              
        ]);
        
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            Language::create([
                    'name' => Input::get('name'),
                    'code' => Input::get('code'),
                    'is_active' => $input['is_active'],
                    'ordering' => Input::get('ordering'),
                    'image' => Input::get('image')
            ]);
            
            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            
            return redirect('admin/language')->with('nmessage','Save Successfully');
        }
    }

    public function show($id)
    {
                      
        $data = Language::findOrFail($id);
        
        return view('Admin.language.view')->with('data',$data)
                                            ->with('view_title',$this->view_title)
                                            ->with('action',"Edition");
    }

    public function edit($id)
    {

        $data = Language::findOrFail($id);
        
        return view('Admin.language.edit')->with('data',$data)
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
        $project = Language::find($id);        
        
        $validator = Validator::make($input, [
                'code' => 'required|max:3',
                'name' => 'required'               
        ]);
        
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            $project->update($input);
           
            //##########Set Event for ActivityLog############
            $eventName = 'update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            return redirect('/admin/setting/language')->with('message','Update Successfully');
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
        $data=Language::find($id)->delete();
        
        //delete from table content_description
        DB::table('content_description')->where('language_id', $id)->delete();
        DB::table('content_category_description')->where('language_id', $id)->delete();
        DB::table('fmenu_description')->where('language_id', $id)->delete();

        return redirect()->back()->with('message','Deleted successfully');
    }

}
