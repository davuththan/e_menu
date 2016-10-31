<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PositionRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\Position;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class RecentEventController extends Controller
{
	
	public $view_title = "Event Management <small> >> Recent Events</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {   
        if(Session::get('applangId')){
            $language_id = Session::get('applangId');
        }else{
            $language_id = CONFIG_LANGUAGE;
        }

        $get_records = DB::table('event_description as ed')
                        ->Join('event as e','ed.event_id','=','e.id')
                        ->Select('ed.*','e.*')
                        ->Where('ed.language_id',$language_id)
                        ->Where('e.event_start','<=',$this->DateNow())
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $data_arr[] = array(
                'id' => $get_record->id,
                'event_start' => $this->FormatDate($get_record->event_start),
                'event_end' => $this->FormatDate($get_record->event_end),
                'publish_date' => $this->FormatDate($get_record->publish_date),
                'is_active' => $get_record->is_active,
                'name' => $get_record->name,
            );
        }

        return view('Admin.event_mgr.recent_event.index')
                ->with('get_records',$data_arr)
                ->with('view_title',$this->view_title);
    }


    public function show($id)
    {
        $RecentEvents = Position::find($id);
        return view('Admin.event_mgr.recent_event.form')->with('RecentEvents',$RecentEvents)
                            ->with('view_title',$this->view_title)
                            ->with('action',"View");
    }
 

}
