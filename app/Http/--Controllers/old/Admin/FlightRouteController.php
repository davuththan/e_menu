<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FlightRoute;
use App\Models\Admin\Language;
use App\Models\Admin\FlightOrigin;
use App\Models\Admin\FlightDestination;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class FlightRouteController extends Controller {

    public $view_title = "Flight Route";
    public $view_sub_title = "Flight Route List";

    public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's61';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    public function index()
    {   
        $data = FlightRoute::get();
        return view('Admin.flight.route.index')
                ->with('data',$data)
                ->with('view_title',$this->view_title)
                ->with('view_sub_title',$this->view_sub_title);
    }

    public function create()
    {   
        $origin = FlightOrigin::lists('name','id');
        $destination = FlightDestination::lists('name','id');
        $languages = Language::all();
        return view('Admin.flight.route.create')->with('languages',$languages)
                                                        ->with('view_title',$this->view_title)
                                                        ->with('origin',$origin)
                                                        ->with('destination',$destination)
                                                        ->with('action',"Create");
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if(isset($input['is_active'])) $input['is_active'] = 1;
        else $input['is_active'] = 0;

        $rules = array( 
          'name' => 'required',
          'origin_id' => 'required',
          'destination_id' => 'required'
        );

        $messages = [
           'name.required' => 'Name is required!',
           'origin_id.required' => 'Origin is required!',
           'destination_id.required' => 'Destination is required!',
       ];

        $v = Validator::make($input, $rules,$messages);
        //dd($job_12);
        if($v->fails()){
            return Redirect::to('/admin/fmgr/f_route/create')->withInput()->withErrors($v);
        }else{
            $name = $input['name'];
            $origin = $input['origin_id'];
            $destination = $input['destination_id'];
            $is_active = $input['is_active'];

            $data = new FlightRoute(array(
                'name'      => $origin,
                'origin_id'      => $origin,
                'destination_id'      => $destination,
                'is_active' => $is_active
            ));

            $data->save();

            //##########Set Event for ActivityLog############
            $eventName = 'create';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();
            return redirect('admin/fmgr/f_route')->with('message','Save Successfully');
        }
    }

    public function show($id)
    {
        $data = FlightRoute::find($id); 
        $languages = Language::all();
        return view('Admin.flight.route.show')->with('languages',$languages)
                                             ->with('data',$data)
                                             ->with('view_title',$this->view_title)
                                             ->with('action',"View");
    }

    public function edit($id)
    {

        $origin = FlightOrigin::lists('name','id');
        $destination = FlightDestination::lists('name','id');

        $data = FlightRoute::find($id); 
        $languages = Language::all();
        return view('Admin.flight.route.edit')->with('languages',$languages)
                                              ->with('data',$data)
                                              ->with('origin',$origin)
                                              ->with('destination',$destination)
                                              ->with('view_title',$this->view_title)
                                              ->with('action',"View");
        
    }

    public function update(Request $request, $id)
    {
        if(!$request->has('is_active')){
            $request->offsetSet('is_active','0');
        }

        $input = $request->all();

        $data = FlightRoute::find($id);
        $rules = array( 'name'=>'required','origin_id' => 'required','destination_id' => 'required');
        $messages = ['name.required'=> 'Name is required!','origin.required' => 'Origin is required!','destination.required' => 'Destination is required!'];
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
            return redirect('admin/fmgr/f_route')->with('message','Update Successfully');
        }
    }

    public function destroy($id)
    {
        FlightRoute::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
