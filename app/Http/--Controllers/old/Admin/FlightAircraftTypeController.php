<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightAircraftType;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightAircraftTypeController extends Controller {

	public $view_title = "Flight Aircraft Type";
	public $view_sub_title = "Flight Aircraft List";

	public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's57';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
        $data = FlightAircraftType::orderBy('id', 'DESC')->get();
        return view('Admin.flight.aircraft_type.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$languages = Language::all();
        return view('Admin.flight.aircraft_type.create')->with('languages',$languages)
    		                                            ->with('view_title',$this->view_title)
    		                                            ->with('action',"Create");
	}

	public function store(Request $request)
	{
        $input = $request->all();
        if(isset($input['is_active'])) $input['is_active'] = 1;
        else $input['is_active'] = 0;

        $rules = array(	
          'name' => 'required'
        );

        $messages = [
           'name.required' => 'Name is required!',
       ];

        $v = Validator::make($input, $rules,$messages);
        //dd($job_12);
        if($v->fails()){
        	return Redirect::to('/admin/fmgr/f_aircraft_type/create')->withErrors($v);
        }else{
            $name = $input['name'];
            $is_active = $input['is_active'];

            $data = new FlightAircraftType(array(
	            'name'      => $name,
	            'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_aircraft_type')->with('message','Save Successfully');
        }
	}

	public function show($id)
	{
		$data = FlightAircraftType::find($id); 
        $languages = Language::all();
        return view('Admin.flight.aircraft_type.show')->with('languages',$languages)
                                             ->with('data',$data)
                                             ->with('view_title',$this->view_title)
                                             ->with('action',"View");
	}

	public function edit($id)
	{
		$data = FlightAircraftType::find($id); 
        $languages = Language::all();
        return view('Admin.flight.aircraft_type.edit')->with('languages',$languages)
                                             ->with('data',$data)
                                             ->with('view_title',$this->view_title)
                                             ->with('action',"View");
		
	}

	public function update(Request $request, $id)
	{
		if(!$request->has('is_active')){
			$request->offsetSet('is_active','0');
		}

        $input = $request->all();

        $data = FlightAircraftType::find($id);
        $rules = array(	'name' => 'required');
        $messages = ['name.required' => 'Name is required!',];
        $v = Validator::make($input, $rules,$messages);
        //dd($job_12);
        if($v->fails()){
        	return Redirect::back()->withErrors($v);
        }else{
        	
        	$data->update($input);

            //##########Set Event for ActivityLog############
            $eventName = 'Update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_aircraft_type')->with('message','Update Successfully');
        }
	}

	public function destroy($id)
	{
		FlightAircraftType::find($id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
