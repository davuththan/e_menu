<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\VisionMission;
use App\Models\Admin\Language;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class VisionMissionController extends Controller {

	public $view_title = "Vision & Mission";
	public $view_sub_title = "Vision & Mission Listing";

	public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's51';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
        $data = DB::table('vision_mission as vm')
                ->leftjoin('vision_mission_description as vmd','vm.id','=','vmd.vision_mission_id')
                ->where('vmd.language_id',CONFIG_LANGUAGE)
                ->select('vm.id as id','vm.image as image','vmd.title as title','vm.is_active as is_active')
                ->get();

		//$data = VisionMission::all();
		return view('Admin.content.vision_mission.index')
								->with('data',$data)
								->with('view_title',$this->view_title)
								->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$languages = Language::all();
        return view('Admin.content.vision_mission.create') ->with('languages',$languages)
        		                                            ->with('view_title',$this->view_title)
    		                                                ->with('action',"Create");
	}

	public function store(Request $request)
	{
        $input = $request->all();
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required'); 
        $messages = [
           'image.required' => 'Image is required!',
       ];
        //dd(Input::file('image'));
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules,$messages);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('admin/cmgr/vision_mission/create')->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/vison_mission/'.$date_create; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                //$fileName = rand(11111,99999).'.'.$extension; // renameing image
                $fileName = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

                // sending back with message
                Session::flash('success', 'Upload successfully');     
                //##########Set Event for ActivityLog############
                $eventName = 'create';
                Session::flash('eventName',$eventName);
                $this->ActivityLog();

                $is_active = $input['is_active'];
                $image = $input['image'];

                $vision_mission = new VisionMission(array(  
                    'image' => $date_create.$fileName,
                    'is_active'   => $is_active
                ));

                $vision_mission->save();
                $lastId = $vision_mission->id;
                $langLen = sizeof($input['_language_id']);
                //dd($langLen);
                for($i=0;$i<$langLen;$i++){
                    $language_id = $input['_language_id'][$i];
                    $title = $input['title'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];
                    DB::table('vision_mission_description')->insert(
                        [
                        'vision_mission_id' => $lastId,
                        'language_id' => $language_id,
                        'title' => $title,
                        'description' => $description,
                        'meta_description' => $meta_description,
                        'meta_keywords' => $meta_keywords
                        ]
                    );
                }
 
               return redirect('admin/cmgr/vision_mission')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/cmgr/cmgr/vision_mission/create')
                                ->with('message','Error while uploading!');
            }
        }
    
	}

	public function show($id)
	{
		$vision_mission = VissionMission::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('vision_mission','title',$id,$language_id);
            $description = $this->getDescription('vision_mission','description',$id,$language_id);
            $meta_keywords = $this->getDescription('vision_mission','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('vision_mission','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.vision_mission.show')->with('languages',$languages)
	                                         ->with('vision_mission',$vision_mission)
	                                         ->with('dataDes',$dataDes)
	                                         ->with('location',$location)
	                                         ->with('view_title',$this->view_title)
	                                         ->with('action',"View");
	}

	public function edit($id)
	{
		$vision_mission = VisionMission::find($id); 
        $languages = Language::all();  
        $dataD= array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('vision_mission','title',$id,$language_id);
            $description = $this->getDescription('vision_mission','description',$id,$language_id);
            $meta_keywords = $this->getDescription('vision_mission','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('vision_mission','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.vision_mission.edit')->with('languages',$languages)
	                                         ->with('vision_mission',$vision_mission)
	                                         ->with('dataDes',$dataDes)
	                                         ->with('view_title',$this->view_title)
	                                         ->with('action',"Edition");
		
	}

	public function update(Request $request, $id)
	{

        if(!$request->has('is_active')){
            $request->offsetSet('is_active','0');
        }

        $input = $request->all();
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required');
        $picname = Input::file('image');
        //dd(Input::file('image'));
        //dd($picname);
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/vison_mission/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            //$fileName = rand(11111,99999).'.'.$extension; // renameing image
            $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

            // sending back with message
            Session::flash('success', 'Upload successfully');     
            //##########Set Event for ActivityLog############
            $eventName = 'Updated';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            $is_active = $input['is_active'];
            $image = $input['image'];

             DB::table('vision_mission')
                    ->where('id',$id)
                    ->update([
                        'image' => $date_create.$fileName
                    ]);
        }

        $vision_mission = DB::table('vision_mission')
                ->where('id',$id)
                ->update([
                    'is_active'   => $input['is_active']
                ]);

        $langLen = sizeof($input['_language_id']);
        //dd($langLen);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['_language_id'][$i];
            $title = $input['title'][$i];
            $description = $input['description_'.$language_id];
            $meta_keywords = $input['meta_keywords'][$i];
            $meta_description = $input['meta_description'][$i];

            $query = DB::table('vision_mission_description')->where('vision_mission_id', $id)
                        ->where('language_id', $language_id)
                        ->update(
                            [
                            'title' => $title,
                            'description' => $description,
                            'meta_description' => $meta_description,
                            'meta_keywords' => $meta_keywords
                            ]
             );
            
        }
        return redirect('admin/cmgr/vision_mission')->with('message','Update Successfully');
	}

	public function destroy($id)
	{
		VisionMission::find($id)->delete();
		DB::table('vision_mission_description')->where('vision_mission_id', $id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
