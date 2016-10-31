<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightNumber;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightNumberController extends Controller {

    public $view_title = "Flight Number";
    public $view_sub_title = "Flight Number List";

    public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's54';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    public function index()
    {   
        $data = FlightNumber::orderBy('id', 'DESC')->get();
        return view('Admin.flight.number.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
    }

    public function create()
    {   
        $languages = Language::all();
        return view('Admin.flight.number.create')->with('languages',$languages)
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
            return Redirect::to('/admin/fmgr/f_number/create')->withErrors($v);
        }else{
            $name = $input['name'];
            $is_active = $input['is_active'];

            $data = new FlightNumber(array(
                'name'      => $name,
                'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_number')->with('message','Save Successfully');
        }
    }

    public function show($id)
    {
        $data = FlightNumber::find($id); 
        $languages = Language::all();
        return view('Admin.flight.number.show')->with('languages',$languages)
            ->with('data',$data)
            ->with('view_title',$this->view_title)
            ->with('action',"View");
    }

    public function edit($id)
    {
        $data = FlightNumber::find($id); 
        $languages = Language::all();
        return view('Admin.flight.number.edit')->with('languages',$languages)
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

        $data = FlightNumber::find($id);
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
            return redirect('admin/fmgr/f_number')->with('message','Update Successfully');
        }
    }

    public function destroy($id)
    {
        FlightNumber::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
