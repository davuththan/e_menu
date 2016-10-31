<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\ConfigGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\ConfigGroup;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class ConfigGroupController extends Controller
{
	
	public $view_title = "Config Group";
	

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's39';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	
        $alldata = ConfigGroup::all();
        
        return view('Admin.config_group.index')->with('alldata',$alldata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {		
        return view('Admin.config_group.create')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ConfigGroupRequest $request)
    {
        
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            ConfigGroup::create($input);

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            	
            return redirect('admin/setting/config_group')->with('nmessage','Save Successfully');
        }		
    }

   
    public function edit($id)
    {       
        $data = ConfigGroup::find($id);
         
        return view('Admin.config_group.edit')->with('config_group',$data)
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
        
        $project = ConfigGroup::find($id);
        
        $validator = Validator::make($input, [
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

            return redirect('/admin/setting/config_group')->with('message','Save Successfully');
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
        $data=ConfigGroup::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
