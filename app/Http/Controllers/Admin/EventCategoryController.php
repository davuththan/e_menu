<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventCategoryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\EventCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class EventCategoryController extends Controller
{
    
    public $view_title = "Event Management <small> >> Event Category</small>";
    

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

        // $get_records = DB::table('event_category_description as ecd')
        //                 ->Join('event_category as ec','ecd.event_category_id','=','ec.id')
        //                 ->Select('ecd.*','ec.id as id')
        //                 ->Where('ecd.language_id',$language_id)
        //                 ->get();
        $get_records = EventCategory::all();
        $data_arr = array();
        foreach ($get_records as $get_record) {
            $data_arr[] = array(
                'id' => $get_record->id,
                'name' => $get_record->name,
            );
        }

        return view('Admin.event_mgr.event_category.index')
                ->with('get_records',$data_arr)
                ->with('view_title',$this->view_title);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.event_mgr.event_category.form')
                                ->with('view_title',$this->view_title)
                                ->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $input = $request->all();
        $langLen = sizeof($input['language_id']);

        $lastId = DB::table('event_category')->insertGetId(
            [
                'modified_by' => $input['modified_by'],
                'created_at' => $this->DateNow(),
                'updated_at' => $this->DateNow()
            ]
         );

        for($i=0;$i<$langLen;$i++){
            $language_id = $input['language_id'][$i];
            $name = $input['name_'.$language_id];
            $description = $input['description_'.$language_id];

            DB::table('event_category_description')->insert(
                [
                'event_category_id' => intval($lastId),
                'language_id' => intval($language_id),
                'name' => $name,
                'description' => $description
                ]
            );
        }

        return redirect("admin/event_mgr/event_category")->with('message',"Event Category has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $get_records = DB::table('event_category_description as ecd')
                        ->Join('event_category as ec','ecd.event_category_id','=','ec.id')
                        ->Select('ecd.*','ec.id as id')
                        ->Where('ecd.event_category_id',$id)
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $lang_id = $get_record->language_id;
            $data_arr[$lang_id] = array(
                'id' => $get_record->id,
                'language_id' => $lang_id,
                'name' => htmlentities($get_record->name),
                'description' => htmlentities($get_record->description),
            );
        }

        $EventCategorys = EventCategory::find($id);
        return view('Admin.event_mgr.event_category.form')
                    ->with('EventCategorys',$EventCategorys)
                    ->with('data_arr',$data_arr)
                    ->with('view_title',$this->view_title)
                    ->with('action',"View");
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {   
        $get_records = DB::table('event_category_description as ecd')
                        ->Join('event_category as ec','ecd.event_category_id','=','ec.id')
                        ->Select('ecd.*','ec.id as id')
                        ->Where('ecd.event_category_id',$id)
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $lang_id = $get_record->language_id;
            $data_arr[$lang_id] = array(
                'id' => $get_record->id,
                'language_id' => $lang_id,
                'name' => htmlentities($get_record->name),
                'description' => htmlentities($get_record->description),
            );
        }

        $EventCategorys = EventCategory::find($id);
        return view('Admin.event_mgr.event_category.form')
                    ->with('EventCategorys',$EventCategorys)
                    ->with('data_arr',$data_arr)
                    ->with('view_title',$this->view_title)
                    ->with('action',"Edit");
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
        $langLen = sizeof($input['language_id']);

        DB::table('event_category')
                    ->where('id', $id)
                    ->update(
                        [
                            'updated_at' => $this->DateNow(),
                        ]
                    );

        // dd($langLen);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['language_id'][$i];
            $name = $input['name_'.$language_id];
            $description = $input['description_'.$language_id];
            DB::table('event_category_description')->where('event_category_id', $id)
                    ->where('language_id', $language_id)
                    ->update(
                        ['name' => $name,
                        'description' => $description
                        ]
                    );
        }

       return redirect("admin/event_mgr/event_category")->with('message',"Event Category has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        EventCategory::find($id)->delete();
        DB::table('event_category_description')->where('event_category_id',$id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
