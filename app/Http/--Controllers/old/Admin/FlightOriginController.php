<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightOrigin;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightOriginController extends Controller {

    public $view_title = "Flight Origin";
    public $view_sub_title = "Flight Origin List";

    public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's52';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    public function index()
    {   
        $data = FlightOrigin::orderBy('id', 'DESC')->get();
        return view('Admin.flight.origin.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
    }

    public function create()
    {   
        $languages = Language::all();
        return view('Admin.flight.origin.create')->with('languages',$languages)
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
            return Redirect::to('/admin/fmgr/f_origin/create')->withErrors($v);
        }else{
            $name = $input['name'];
            $is_active = $input['is_active'];

            $data = new FlightOrigin(array(
                'name'      => $name,
                'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_origin')->with('message','Save Successfully');
        }
    }

    public function show($id)
    {
        $data = FlightOrigin::find($id); 
        $languages = Language::all();
        return view('Admin.flight.origin.show')->with('languages',$languages)
                                             ->with('data',$data)
                                             ->with('view_title',$this->view_title)
                                             ->with('action',"View");
    }

    public function edit($id)
    {
        $data = FlightOrigin::find($id); 
        $languages = Language::all();
        return view('Admin.flight.origin.edit')->with('languages',$languages)
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

        $data = FlightOrigin::find($id);
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
            return redirect('admin/fmgr/f_origin')->with('message','Update Successfully');
        }
    }

    public function destroy($id)
    {
        FlightOrigin::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
