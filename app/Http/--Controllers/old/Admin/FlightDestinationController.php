<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightDestination;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightDestinationController extends Controller {

    public $view_title = "Flight Destination";
    public $view_sub_title = "Flight Destination List";

    public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's53';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    public function index()
    {   
        $data = FlightDestination::orderBy('id', 'DESC')->get();
        return view('Admin.flight.destination.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
    }

    public function create()
    {   
        $languages = Language::all();
        return view('Admin.flight.destination.create')->with('languages',$languages)
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
            return Redirect::to('/admin/fmgr/f_destination/create')->withErrors($v);
        }else{
            $name = $input['name'];
            $is_active = $input['is_active'];

            $data = new FlightDestination(array(
                'name'      => $name,
                'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_destination')->with('message','Save Successfully');
        }
    }

    public function show($id)
    {
        $data = FlightDestination::find($id); 
        $languages = Language::all();
        return view('Admin.flight.destination.show')->with('languages',$languages)
                                             ->with('data',$data)
                                             ->with('view_title',$this->view_title)
                                             ->with('action',"View");
    }

    public function edit($id)
    {
        $data = FlightDestination::find($id); 
        $languages = Language::all();
        return view('Admin.flight.destination.edit')->with('languages',$languages)
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

        $data = FlightDestination::find($id);
        $rules = array( 'name' => 'required');
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
            return redirect('admin/fmgr/f_destination')->with('message','Update Successfully');
        }
    }

    public function destroy($id)
    {
        FlightDestination::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
