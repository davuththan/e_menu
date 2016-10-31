<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightTime;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightTimeController extends Controller {

    public $view_title = "Flight Time";
    public $view_sub_title = "Flight Time List";

    public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's54';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    public function index()
    {   
        $data = FlightTime::all();
        return view('Admin.flight.time.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
    }

    public function create()
    {   
        $languages = Language::all();
        return view('Admin.flight.time.create')->with('languages',$languages)
                                                 ->with('view_title',$this->view_title)
                                                 ->with('action',"Create");
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if(isset($input['is_active'])) $input['is_active'] = 1;
        else $input['is_active'] = 0;

        $rules = array( 
          'time' => 'required'
        );

        $messages = [
           'time.required' => 'Time is required!',
       ];

        $v = Validator::make($input, $rules,$messages);
        //dd($job_12);
        if($v->fails()){
            return Redirect::to('/admin/fmgr/f_time/create')->withErrors($v);
        }else{
            $time = $input['time'];
            $is_active = $input['is_active'];

            $data = new FlightTime(array(
                'time'      => $time,
                'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_time')->with('message','Save Successfully');
        }
    }

    public function show($id)
    {
        $data = FlightTime::find($id); 
        $languages = Language::all();
        return view('Admin.flight.time.show')->with('languages',$languages)
            ->with('data',$data)
            ->with('view_title',$this->view_title)
            ->with('action',"View");
    }

    public function edit($id)
    {
        $data = FlightTime::find($id); 
        $languages = Language::all();
        return view('Admin.flight.time.edit')->with('languages',$languages)
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

        $data = FlightTime::find($id);
        $rules = array( 'time' => 'required');
        $messages = ['time.required' => 'Time is required!',];
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
            return redirect('admin/fmgr/f_time')->with('message','Update Successfully');
        }
    }

    public function destroy($id)
    {
        FlightTime::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
