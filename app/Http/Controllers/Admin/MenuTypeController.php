<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\MenuTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\MenuType;
use Illuminate\Support\Facades\Input;

use DB;
use Validator;
use Auth;
use Session;

class MenuTypeController extends Controller
{
	
	public $view_title = "Menu Type";
	

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
    	
        $alldata = MenuType::all();
        
        return view('Admin.menu_type.index')->with('alldata',$alldata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {		
        return view('Admin.menu_type.create')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(MenuTypeRequest $request)
    {
        
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            MenuType::create($input);

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            	
            return redirect('admin/menu_mgr/mtype')->with('nmessage','Save Successfully');
        }		
    }

   
    public function edit($id)
    {       
        $data = MenuType::find($id);
         
        return view('Admin.menu_type.edit')->with('menu_type',$data)
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
        
        $project = MenuType::find($id);
        
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

            return redirect('/admin/menu_mgr/mtype')->with('message','Save Successfully');
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
        $data=MenuType::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
