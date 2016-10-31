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
      
  public function __construct(){}

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
  
  /*
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
  {

    $event_category = EventCategory::lists('name','id');
    if(Session::get('applangId')){
      $language_id = Session::get('applangId');
    }else{
      $language_id = CONFIG_LANGUAGE;
    }

    $events = DB::table('event_description as ed')
                    ->Join('event as e','ed.event_id','=','e.id')
                    ->Select('e.*','ed.name as event_name','e.id as event_id')
                    ->Where('ed.language_id',$language_id)
                    ->get();

    return view('Admin.event_mgr.event.form')
                ->with('event_category',$event_category)
                ->with('events',$events)
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

      if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
      else $input['is_active'] = 0;

      if(isset($input['is_event'])&&($input['is_event']=='on')) $input['is_event'] = 1;
      else $input['is_event'] = 0;

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
        $attach_file = Input::file('attach_file');
        $date_create = date('d-M-Y/');

        $destinationPath = 'images/upload/events/'.$date_create; 
        if($image!=''){
          $filename_alt = $image->getClientOriginalName();
          $filename = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename_alt);
          Input::file('image')->move($destinationPath, $filename); 
        }

        $file='';
        if($attach_file!=''){
          // $file_attach = $request->get('attach_file');
          $destinationPath = 'images/upload/events/'.$date_create; 
          $extension = Input::file('attach_file')->getClientOriginalExtension();
          // upload pat
          $file_attach_name = Input::file('attach_file')->getClientOriginalName();

          // $file = preg_replace('/\s+/', '_', $file_attach_name);
          $file = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name);
          Input::file('attach_file')->move($destinationPath, $file);
        }

        $lastId = DB::table('event')->insertGetId(
          [
            'image' => $date_create.$filename,
            'attach_file' => $date_create.$file,
            'parent_id' => intval($input['event_sub_category_id']),
            'event_category_id' => $input['event_category_id'],
            'event_start' => $this->ConvertDate($input['event_start']),
            'event_end' => $this->ConvertDate($input['event_end']),
            'publish_date' => $this->ConvertDate($input['publish_date']),
            'modified_by' => $input['modified_by'],
            'is_active' => $input['is_active'],
            'is_event' => $input['is_event'],
            'created_at' => $this->DateNow(),
            'updated_at' => $this->DateNow()
          ]
        );

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

  public function getSubEvent(Request $request)
  {
    if(Session::get('applangId')){
      $language_id = Session::get('applangId');
    }else{
      $language_id = CONFIG_LANGUAGE;
    }

    $input = $request->all();

    // LIKE '" . $this->db->escape($data['filter_name']) . "%'
    $getSubEvents = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Select('e.*','ed.name as event_name','e.id as event_id')
                      ->Where('ed.name','LIKE','%'.$input['filter_name'].'%')
                      ->Where('ed.language_id',$language_id)
                      ->Where('e.parent_id','>',0)
                      ->OrderBy('ed.name')
                      ->Limit(10)
                      ->get();

    // print_r($getSubEvents);
    $subEventArray = array();

    foreach ($getSubEvents as $getSubEvent) {
      $subEventArray[] = array(
        'event_name' => $getSubEvent->event_name,
        'event_id' => $getSubEvent->event_id,
      );                        
    }

    return json_encode($subEventArray);
  }

  public function getDataSubEvent(Request $request)
  {
    if(Session::get('applangId')){
      $language_id = Session::get('applangId');
    }else{
      $language_id = CONFIG_LANGUAGE;
    }

    $input = $request->all();

    // LIKE '" . $this->db->escape($data['filter_name']) . "%'
    $getSubEvents = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Select('e.*','ed.name as event_name','e.id as event_id')
                      ->Where('ed.name','LIKE','%'.$input['filter_name'].'%')
                      ->Where('ed.language_id',$language_id)
                      ->Where('e.parent_id','=',0)
                      ->OrderBy('ed.name')
                      ->Limit(10)
                      ->get();
    // print_r($getSubEvents);
    $subEventArray = array();

    foreach ($getSubEvents as $getSubEvent) {
      $subEventArray[] = array(
        'event_name' => $getSubEvent->event_name,
        'event_id' => $getSubEvent->event_id,
      );                        
    }

    return json_encode($subEventArray);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */

  public function show($id)
  {
      if(Session::get('applangId')){
        $language_id = Session::get('applangId');
      }else{
        $language_id = CONFIG_LANGUAGE;
      }


      $events = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Join('event_data as edt','edt.event_id','=','e.id')
                      ->Select('e.*','ed.name as event_name','e.id as event_id')
                      ->Where('ed.language_id',$language_id)
                      ->Where('edt.parent_id',$id)
                      ->OrderBy('ed.name')
                      ->get();


      // getRecords
      $get_records = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Select('ed.*','e.*')
                      ->Where('ed.event_id',$id)
                      ->get();
      
      // getParent
      $sub_event_name='';
      $sub_event_id='';

      // check if event = 1;
      $is_event = DB::table('event')->where('id', $id)->pluck('is_event');
      // if($is_event==1){
        $getParent = DB::table('event')->where('id', $id)->pluck('parent_id');

        if($getParent!=0){
          // get sub event cate
          $get_one_sub_event_cat = DB::table('event_description as ed')
                                    ->Join('event as e','ed.event_id','=','e.id')
                                    ->Select('ed.name as event_name','e.id as event_id')
                                    ->Where('ed.language_id',$language_id)
                                    ->Where('e.id',$getParent)
                                    ->OrderBy('ed.name')
                                    ->first();
          
          $sub_event_name = $get_one_sub_event_cat->event_name;
          $sub_event_id = $get_one_sub_event_cat->event_id;
        }

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
              'is_event' => $get_record->is_event,
              'name' => htmlentities($get_record->name),
              'description' => htmlentities($get_record->description),
              'meta_keyword' => $get_record->meta_keyword,
              'meta_description' => $get_record->meta_description,
            );
        }
        $event_category = EventCategory::lists('name','id');
        $Events = Event::find($id);

        // getListData
        $data_images = $this->getEventImages($id);
        $data_files = $this->getEventFiles($id);
      // }

      return view('Admin.event_mgr.event.form')
                  ->with('Events',$Events)
                  ->with('data_arr',$data_arr)
                  ->with('event_category',$event_category)
                  ->with('sub_event_name',$sub_event_name)
                  ->with('sub_event_id',$sub_event_id)
                  ->with('view_title',$this->view_title)
                  ->with('events',$events)
                  ->with('data_images',$data_images)
                  ->with('data_files',$data_files)
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
      if(Session::get('applangId')){
        $language_id = Session::get('applangId');
      }else{
        $language_id = CONFIG_LANGUAGE;
      }


      $events = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Join('event_data as edt','edt.event_id','=','e.id')
                      ->Select('e.*','ed.name as event_name','e.id as event_id')
                      ->Where('ed.language_id',$language_id)
                      ->Where('edt.parent_id',$id)
                      ->OrderBy('ed.name')
                      ->get();


      // getRecords
      $get_records = DB::table('event_description as ed')
                      ->Join('event as e','ed.event_id','=','e.id')
                      ->Select('ed.*','e.*')
                      ->Where('ed.event_id',$id)
                      ->get();
      
      // getParent
      $sub_event_name='';
      $sub_event_id='';

      // check if event = 1;
      $is_event = DB::table('event')->where('id', $id)->pluck('is_event');
      // if($is_event==1){
        $getParent = DB::table('event')->where('id', $id)->pluck('parent_id');

        if($getParent!=0){
          // get sub event cate
          $get_one_sub_event_cat = DB::table('event_description as ed')
                                    ->Join('event as e','ed.event_id','=','e.id')
                                    ->Select('ed.name as event_name','e.id as event_id')
                                    ->Where('ed.language_id',$language_id)
                                    ->Where('e.id',$getParent)
                                    ->OrderBy('ed.name')
                                    ->first();
          
          $sub_event_name = $get_one_sub_event_cat->event_name;
          $sub_event_id = $get_one_sub_event_cat->event_id;
        }

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
              'is_event' => $get_record->is_event,
              'name' => htmlentities($get_record->name),
              'description' => htmlentities($get_record->description),
              'meta_keyword' => $get_record->meta_keyword,
              'meta_description' => $get_record->meta_description,
            );
        }
        $event_category = EventCategory::lists('name','id');
        $Events = Event::find($id);

        // getListData
        $data_images = $this->getEventImages($id);
        $data_files = $this->getEventFiles($id);
      // }

      return view('Admin.event_mgr.event.form')
                  ->with('Events',$Events)
                  ->with('data_arr',$data_arr)
                  ->with('event_category',$event_category)
                  ->with('sub_event_name',$sub_event_name)
                  ->with('sub_event_id',$sub_event_id)
                  ->with('view_title',$this->view_title)
                  ->with('events',$events)
                  ->with('data_images',$data_images)
                  ->with('data_files',$data_files)
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
    // dd($input['attribute_data']);
    // getForm
    $this->getForm($input,$id);
    // langLen
    $langLen = sizeof($input['language_id']);
    if(isset($input['is_active'])&&($input['is_active']=='on')) $input['is_active'] = 1;
    else $input['is_active'] = 0;

    if(isset($input['is_event'])&&($input['is_event']=='on')) $input['is_event'] = 1;
    else $input['is_event'] = 0;

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
        $filename_alt = $image->getClientOriginalName();
        $filename = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename_alt);
        Input::file('image')->move($destinationPath, $filename);
        DB::table('event')->where('id', $id)
              ->update(
                  [
                    'parent_id' => intval($input['event_sub_category_id']),
                    'image' => $date_create.$filename,
                    'event_category_id' => $input['event_category_id'],
                    'event_start' => $this->ConvertDate($input['event_start']),
                    'event_end' => $this->ConvertDate($input['event_end']),
                    'publish_date' => $this->ConvertDate($input['publish_date']),
                    'modified_by' => $input['modified_by'],
                    'is_server' => 0,
                    'is_active' => $input['is_active'],
                    'is_event' => $input['is_event'],
                    'created_at' => $this->DateNow(),
                    'updated_at' => $this->DateNow()
                  ]
              ); 
      }else{
        DB::table('event')->where('id', $id)
              ->update(
                  [
                  'parent_id' => intval($input['event_sub_category_id']),
                  'event_category_id' => $input['event_category_id'],
                  'event_start' => $this->ConvertDate($input['event_start']),
                  'event_end' => $this->ConvertDate($input['event_end']),
                  'publish_date' => $this->ConvertDate($input['publish_date']),
                  'modified_by' => $input['modified_by'],
                  'is_server' => 0,
                  'is_active' => $input['is_active'],
                  'is_event' => $input['is_event'],
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

  // getForm
  public function getForm($request,$id){
    // dd($request['attribute_image']);
    // dd($request['attribute_data']);
    if(isset($request['data_event_category'])){
      $event_sub_categories = $request['data_event_category'];
      DB::table('event_data')->where('parent_id',$id)->delete();
      $i=0;
      for($i=0;$i<=count($request['data_event_category'])-1;$i++) {
        DB::table('event_data')->insert(
          [
            'parent_id' => intval($id),
            'event_id' => $request['data_event_category'][$i]
          ]
        );
      }
    }

    // attribute_image
    // dd($request['attribute_image']);
    $date_create = date('d-M-Y/');
    if(isset($request['attribute_image'])){
      $attribute_images = $request['attribute_image'];
      DB::table('event_image')->where('event_id',$id)->delete();
      foreach ($attribute_images as $attribute_image) {
        // dd($attribute_image['image']);
        $filename_image='';
        $image = $attribute_image['image'];
        if(isset($attribute_image['image'])){
          $destinationPath = 'images/upload/events/'.$date_create;
          $filename_image_alt = $image->getClientOriginalName();
          $filename_image = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename_image_alt);
          $image->move($destinationPath, $filename_image);

          DB::table('event_image')->insert(
            [
              'event_id' => intval($id),
              'name' => $attribute_image['name'],
              'image' => $date_create.$filename_image,
              'order_level' => $attribute_image['order_level'],
            ]
          );

        }else{
          
          DB::table('event_image')->insert(
            [
              'event_id' => intval($id),
              'name' => $attribute_image['name'],
              'image' => $attribute_image['image_hidden'],
              'order_level' => $attribute_image['order_level'],
            ]
          );
          
        }

      }
    }

    // attribute
    if(isset($request['attribute_data'])){
      $attributes_data = $request['attribute_data'];
      // dd($request('attribute_data'));
      DB::table('event_file')->where('event_id',$id)->delete();
      foreach ($attributes_data as $attribute_data) {
        $file='';
        // if($attribute_data['attach_file']!=''){
        $file_attachs = $attribute_data['attach_file'];
        if(isset($attribute_data['attach_file'])){

          // $file_attach = $request->get('attach_file');
          $destinationPath = 'images/upload/events/'.$date_create; 
          // $extension = $file_attachs->getClientOriginalExtension();
          // upload pat
          $file_attach_name = $file_attachs->getClientOriginalName();

          // $file = preg_replace('/\s+/', '_', $file_attach_name);
          $file = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name);
          $file_attachs->move($destinationPath, $file);

          DB::table('event_file')
            ->insert(
            [
            'event_id' => intval($id),
            'name' => $attribute_data['name'],
            'attach_file' => $date_create.$file,
            'order_level' => $attribute_data['order_level'],
            ]
          );

        }else{

          DB::table('event_file')
            ->insert(
            [
            'event_id' => intval($id),
            'name' => $attribute_data['name'],
            'attach_file' => $attribute_data['attach_file_hidden'],
            'order_level' => $attribute_data['order_level'],
            ]
          );
        }

      }
    }

  }

  // getEventImages
  public function getEventImages($id){
    $data = array();
    $EventImages = DB::table('event_image')
          ->Where('event_id',$id)
          ->get();

    foreach ($EventImages as $EventImage) {
      $data[] = array(
        'image' => $EventImage->image,
        'name'  => $EventImage->name,
        'order_level'  => $EventImage->order_level,
      );
    }

    // dd($data);
    return $data;

  }

  // getEventFiles
  public function getEventFiles($id){
    $data = array();
    $EventImages = DB::table('event_file')
          ->Where('event_id',$id)
          ->get();

    foreach ($EventImages as $EventImage) {
      $data[] = array(
        'file' => $EventImage->attach_file,
        'name'  => $EventImage->name,
        'order_level'  => $EventImage->order_level,
      );
    }
    
    // dd($data);
    return $data;

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
