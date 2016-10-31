<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\ConfigRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Config;
use App\Models\Admin\ConfigGroup;
use App\Models\Admin\Language;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class ConfigController extends Controller
{
	
	public $view_title = "Config";
	

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's38';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	
        //$results = Config::with('config_group')->get();
        //dd($results);
        $alldata = DB::table('config')
        ->join('config_group', 'config_group.id', '=', 'config.config_group_id')
        ->select('config.*', 'config_group.name as cg_name')
        ->orderBy('config_group.id', 'asc')
        ->get();
        
        return view('Admin.config.index')->with('alldata',$alldata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
        $config_group = ConfigGroup::lists('name','id');
		
        return view('Admin.config.create')->with('config_group',$config_group)
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ConfigRequest $request)
    {
        
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'config_group_id' => 'required',
            'keywords' => 'required',
            'value' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            Config::create($input);

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            	
            return redirect('admin/setting/config')->with('message','Save Successfully');
        }		
    }

   
    public function edit($id)
    {
        
        $config_group = ConfigGroup::lists('name','id');
               
        $data = Config::find($id);
        
        
        
        return view('Admin.config.edit')->with('config_group',$config_group)
									        ->with('config',$data)
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
        
        $project = Config::find($id);
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'config_group_id' => 'required',
            'keywords' => 'required',
            'value' => 'required'
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

            return redirect('/admin/setting/config')->with('message','Save Successfully');
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
