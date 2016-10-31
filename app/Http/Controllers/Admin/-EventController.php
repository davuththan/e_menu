<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\EventCategory;
use App\Models\Admin\Event;
use App\Models\Admin\EventDescription;
use Illuminate\Support\Facades\Input;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class EventController extends Controller
{
    
    public $view_title = "Event Management <small> >> Event</small>";
    

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
                        ->Join('event_category as ec','ec.id','=','e.event_category_id')
                        ->Select('ed.*','e.*','ec.name as event_category_name')
                        ->Where('ed.language_id',$language_id)
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $data_arr[] = array(
                'id' => $get_record->id,
                'event_category_name' => $get_record->event_category_name,
                'event_start' => $this->FormatDate($get_record->event_start),
                'event_end' => $this->FormatDate($get_record->event_end),
                'publish_date' => $this->FormatDate($get_record->publish_date),
                'is_active' => $get_record->is_active,
                'name' => $get_record->name,
            );
        }

        return view('Admin.event_mgr.event.index')
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
      $event_category = EventCategory::lists('name','id');
      return view('Admin.event_mgr.event.form')
                                ->with('event_category',$event_category)
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
        $date_create = date('d-M-Y/');
        if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
        else $input['is_active'] = 0;


        $data_arr = array(
                    'event_start' => $input['publish_date'],
                    'event_end' => $input['event_end'],
                    'publish_date' => $input['publish_date'],
                );
        // setting up rules
        $rules = array(
                'event_start' => 'required',
                'event_end' => 'required',
                'publish_date' => 'required',
            ); 
        $messages = [
           'event_start.required' => 'Event Start is required!',
           'event_end.required' => 'Event End is required!',
           'publish_date.required' => 'Event Publish is required!',
       ];
        
        $validator = Validator::make($data_arr,$rules,$messages);

        if ($validator->fails())
        {
          return redirect()->back()->withErrors($validator->errors());
        }else{ 

          $filename='';
          $image = Input::file('image');
          

          $destinationPath = 'images/upload/events/'.$date_create; 
          if($image!=''){
            $filename = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $filename); 
          }
          
          if (Input::file('attach_file')!='') {
            $rules = array(
              'name' => 'Required',
              'attach_file' => 'max:'.$size 
            );
            $messages = [
               'name.required' => 'Provide your name!',
               'attach_file.max' =>'Max attachment file size is '.MAX_FILE_SIZE.'!',      
            ];

            $v = Validator::make($input, $rules, $messages);
            if($v->passes()){

              $file_attach = $request->get('attach_file');
              $destinationPath = 'images/upload/useful_information/attach_file/'.$date_create; 
              $extension = Input::file('attach_file')->getClientOriginalExtension();
              // upload pat
              $file_attach_name = Input::file('attach_file')->getClientOriginalName();

              $file = preg_replace('/\s+/', '_', $file_attach_name);

              Input::file('attach_file')->move($destinationPath, $file);
            
              $pathToFile = SITE_HTTP_URL.'images/upload/useful_information/attach_file/'.$date_create.$file;


              $lastId = DB::table('event')->insertGetId(
                [
                  'image' => $date_create.$filename,
                  'event_category_id' => $input['event_category_id'],
                  'event_start' => $this->ConvertDate($input['event_start']),
                  'event_end' => $this->ConvertDate($input['event_end']),
                  'publish_date' => $this->ConvertDate($input['publish_date']),
                  'modified_by' => $input['modified_by'],
                  'attach_file' => $date_create.$file,
                  'is_active' => $input['is_active'],
                  'created_at' => $this->DateNow(),
                  'updated_at' => $this->DateNow()
                ]
              );
            }else{
              $lastId = DB::table('event')->insertGetId(
                [
                  'image' => $date_create.$filename,
                  'event_category_id' => $input['event_category_id'],
                  'event_start' => $this->ConvertDate($input['event_start']),
                  'event_end' => $this->ConvertDate($input['event_end']),
                  'publish_date' => $this->ConvertDate($input['publish_date']),
                  'modified_by' => $input['modified_by'],
                  'is_active' => $input['is_active'],
                  'created_at' => $this->DateNow(),
                  'updated_at' => $this->DateNow()
                ]
              );
            }

          // $user = User::create($loginuserdata);
          // $insertedId = $user->id;

          for($i=0;$i<$langLen;$i++){
              $language_id = $input['language_id'][$i];
              $name = $input['name_'.$language_id];
              $description = $input['description_'.$language_id];
              $meta_keyword = $input['meta_keyword_'.$language_id];
              $meta_description = $input['meta_description_'.$language_id];

              DB::table('event_description')->insert(
                  [
                  'event_id' => intval($lastId),
                  'language_id' => intval($language_id),
                  'name' => $name,
                  'description' => $description,
                  'meta_keyword' => $meta_keyword,
                  'meta_description' => $meta_description
                  ]
              );
          }

        }

        return redirect("admin/event_mgr/event")->with('message',"Event has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get_records = DB::table('event_description as ed')
                        ->Join('event as e','ed.event_id','=','e.id')
                        ->Select('ed.*','e.*')
                        ->Where('ed.event_id',$id)
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $lang_id = $get_record->language_id;
            $data_arr[$lang_id] = array(
              'id' => $get_record->id,
              'language_id' => $lang_id,
              'event_start' => $get_record->event_start,
              'event_end' => $get_record->event_end,
              'publish_date' => $get_record->publish_date,
              'is_active' => $get_record->is_active,
              'name' => htmlentities($get_record->name),
              'description' => htmlentities($get_record->description),
              'meta_keyword' => $get_record->meta_keyword,
              'meta_description' => $get_record->meta_description,
            );
        }

        $event_category = EventCategory::lists('name','id');
        $Events = Event::find($id);
        return view('Admin.event_mgr.event.form')
                    ->with('Events',$Events)
                    ->with('data_arr',$data_arr)
                    ->with('event_category',$event_category)
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
        $get_records = DB::table('event_description as ed')
                        ->Join('event as e','ed.event_id','=','e.id')
                        ->Select('ed.*','e.*')
                        ->Where('ed.event_id',$id)
                        ->get();

        $data_arr = array();
        foreach ($get_records as $get_record) {
            $lang_id = $get_record->language_id;
            $data_arr[$lang_id] = array(
                'id' => $get_record->id,
                'language_id' => $lang_id,
                'event_start' => $get_record->event_start,
                'event_end' => $get_record->event_end,
                'publish_date' => $get_record->publish_date,
                'is_active' => $get_record->is_active,
                'name' => htmlentities($get_record->name),
                'description' => htmlentities($get_record->description),
                'meta_keyword' => $get_record->meta_keyword,
                'meta_description' => $get_record->meta_description,
            );
        }
        $event_category = EventCategory::lists('name','id');
        $Events = Event::find($id);
        return view('Admin.event_mgr.event.form')
                    ->with('Events',$Events)
                    ->with('data_arr',$data_arr)
                    ->with('event_category',$event_category)
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

      if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
      else $input['is_active'] = 0;

      $data_arr = array(
                  'event_start' => $input['publish_date'],
                  'event_end' => $input['event_end'],
                  'publish_date' => $input['publish_date'],
              );
      // setting up rules
      $rules = array(
              'event_start' => 'required',
              'event_end' => 'required',
              'publish_date' => 'required',
          ); 
      $messages = [
         'event_start.required' => 'Event Start is required!',
         'event_end.required' => 'Event End is required!',
         'publish_date.required' => 'Event Publish is required!',
     ];
      
      $validator = Validator::make($data_arr,$rules,$messages);

      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator->errors());
      }else{ 

        $filename='';
        $image = Input::file('image');
        $date_create = date('d-M-Y/');

        $destinationPath = 'images/upload/events/'.$date_create; 
        if($image!=''){
          $filename = $image->getClientOriginalName();
          Input::file('image')->move($destinationPath, $filename);
          DB::table('event')->where('id', $id)
                ->update(
                    [
                    'image' => $date_create.$filename,
                    'event_category_id' => $input['event_category_id'],
                    'event_start' => $this->ConvertDate($input['event_start']),
                    'event_end' => $this->ConvertDate($input['event_end']),
                    'publish_date' => $this->ConvertDate($input['publish_date']),
                    'modified_by' => $input['modified_by'],
                    'is_active' => $input['is_active'],
                    'created_at' => $this->DateNow(),
                    'updated_at' => $this->DateNow()
                    ]
                ); 
        }else{
          DB::table('event')->where('id', $id)
                ->update(
                    [
                    'event_category_id' => $input['event_category_id'],
                    'event_start' => $this->ConvertDate($input['event_start']),
                    'event_end' => $this->ConvertDate($input['event_end']),
                    'publish_date' => $this->ConvertDate($input['publish_date']),
                    'modified_by' => $input['modified_by'],
                    'is_active' => $input['is_active'],
                    'created_at' => $this->DateNow(),
                    'updated_at' => $this->DateNow()
                    ]
                ); 
        }
        
        
        // $user = User::create($loginuserdata);
        // $insertedId = $user->id;
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['language_id'][$i];
            $name = $input['name_'.$language_id];
            $description = $input['description_'.$language_id];
            $meta_keyword = $input['meta_keyword_'.$language_id];
            $meta_description = $input['meta_description_'.$language_id];

            DB::table('event_description')
                ->where('event_id', $id)
                ->where('language_id', $language_id)
                ->update(
                    [
                    'name' => $name,
                    'description' => $description,
                    'meta_keyword' => $meta_keyword,
                    'meta_description' => $meta_description
                    ]
                );
        }

      }

      return redirect("admin/event_mgr/event")->with('message',"Event has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        Event::find($id)->delete();
        DB::table('event_description')->where('event_id',$id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
