<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Career;
use App\Models\Admin\Language;
use App\Models\Admin\Location;
use App\Http\Requests\Admin\CareerRequest;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class CareerController extends Controller {

	public $view_title = "Career";
	public $view_sub_title = "Job List";

	public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's50';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
        $data = DB::table('career as c')
                ->leftjoin('career_description as cd','c.id','=','cd.career_id')
                ->where('cd.language_id',CONFIG_LANGUAGE)
                ->select('c.id as id','c.report_to as report_to','c.job_code as job_code','c.is_active as is_active','cd.job_title as job_title','cd.location as location','cd.position_available as position_available')
                ->get();
		//dd($data);
		return view('Admin.content.careers.index')
								->with('data',$data)
								->with('view_title',$this->view_title)
								->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$location = Location::lists('location','id');
		//dd($location);
		$languages = Language::all();
        return view('Admin.content.careers.create') ->with('location',$location)
        											->with('languages',$languages)
		                                            ->with('view_title',$this->view_title)
		                                            ->with('action',"Create");
	}

	public function store(Request $request)
	{
        $input = $request->all();

        $input = $request->all();
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required'); 
        $messages = [
           'image.required' => 'Image is required!',
       ];
       
        $validator = Validator::make($file, $rules,$messages);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('admin/cmgr/career/create')->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/career/'.$date_create; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                //$fileName = rand(11111,99999).'.'.$extension; // renameing image
                $fileName = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

                //##########Set Event for ActivityLog############
                $eventName = 'create';
                Session::flash('eventName',$eventName);
                $this->ActivityLog();
                            
            	$report_to = $input['report_to'];
                $job_code = $input['job_code'];
                $is_active = $input['is_active'];
                
                $career = new Career(array(
                	'report_to'   => $report_to,
                    'image'   => $date_create.$fileName,
                    'job_code'    => $job_code,
                    'is_active'   => $is_active
                ));

                $career->save();
                $lastId = $career->id;
                $langLen = sizeof($input['_language_id']);
                //dd($langLen);
                for($i=0;$i<$langLen;$i++){
                    $language_id = $input['_language_id'][$i];
                    $job_title = $input['job_title'][$i];
                    $location = $input['location'][$i];
                    $position_available = $input['position_available'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];
                    DB::table('career_description')->insert(
                        [
                        'career_id' => $lastId,
                        'language_id' => $language_id,
                        'location' =>$location,
                        'job_title' => $job_title,
                        'position_available' => $position_available,
                        'description' => $description,
                        'meta_description' => $meta_description,
                        'meta_keywords' => $meta_keywords
                        ]
                    );
                }

                return redirect('admin/cmgr/career')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/cmgr/career/create')
                                ->with('message','Error while uploading!');
            }
        }
    
	}

	public function show($id)
	{
		$location = Location::lists('location','id');
        $career = Career::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $job_title = $this->getDescription('career','job_title',$id,$language_id);
            $position_available = $this->getDescription('career','position_available',$id,$language_id);
            $location = $this->getDescription('career','location',$id,$language_id);
            $description = $this->getDescription('career','description',$id,$language_id);
            $meta_keywords = $this->getDescription('career','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('career','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
                'job_title' => $job_title,
                'position_available' => $position_available,
                'location' => $location,
                'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.careers.show')->with('languages',$languages)
                                                 ->with('career',$career)
                                                 ->with('dataDes',$dataDes)
                                                 ->with('location',$location)
                                                 ->with('view_title',$this->view_title)
                                                 ->with('action',"Edition");
	}

	public function edit($id)
	{
		$location = Location::lists('location','id');
		$career = Career::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $job_title = $this->getDescription('career','job_title',$id,$language_id);
            $position_available = $this->getDescription('career','position_available',$id,$language_id);
            $location = $this->getDescription('career','location',$id,$language_id);
            $description = $this->getDescription('career','description',$id,$language_id);
            $meta_keywords = $this->getDescription('career','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('career','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'job_title' => $job_title,
                'position_available' => $position_available,
                'location' => $location,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.careers.edit')->with('languages',$languages)
		                                         ->with('career',$career)
		                                         ->with('dataDes',$dataDes)
		                                         ->with('location',$location)
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
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/career/'.$date_create; // upload path
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

            DB::table('career')
                ->where('id',$id)
                ->update([
                    'image'   => $date_create.$fileName
                    ]);
        }

        $report_to = $input['report_to'];
        $job_code = $input['job_code'];
        $is_active = $input['is_active'];
        $career = DB::table('career')
                ->where('id',$id)
                ->update([
                    'report_to'   => $report_to,
                    'job_code'    => $job_code,
                    'is_active'   => $is_active
                ]);

    	//dd($test);
        $langLen = sizeof($input['_language_id']);
        //dd($langLen);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['_language_id'][$i];
            $job_title = $input['job_title'][$i];
            $position_available = $input['position_available'][$i];
            $location = $input['location'][$i];
            $description = $input['description_'.$language_id];
            $meta_keywords = $input['meta_keywords'][$i];
            $meta_description = $input['meta_description'][$i];

	        $query = DB::table('career_description')->where('career_id', $id)
	                    ->where('language_id', $language_id)
	                    ->update(
	                        [
		                    'job_title' => $job_title,
                            'position_available' =>$position_available,
                            'location' => $location,
		                    'description' => $description,
		                    'meta_description' => $meta_description,
		                    'meta_keywords' => $meta_keywords
		                    ]
             );
        	
        }
        //##########Set Event for ActivityLog############
        $eventName = 'Update';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
        return redirect('admin/cmgr/career')->with('message','Update Successfully');

	}

	public function destroy($id)
	{
		Career::find($id)->delete();
		DB::table('career_description')->where('career_id', $id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
