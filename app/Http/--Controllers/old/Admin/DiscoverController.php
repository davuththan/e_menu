<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Discover;
use App\Models\Admin\Language;
use App\Http\Requests\Admin\CareerRequest;
use DB;
use App\user;
use Validator;
use Auth;
use Session;
use Input;
use View;
use Redirect;

class DiscoverController extends Controller {

	public $view_title = "Discover";
	public $view_sub_title = "Discover Listing";

	public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's49';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
        $data = DB::table('discover as d')
                ->leftjoin('discover_description as dd','d.id','=','dd.discover_id')
                ->where('dd.language_id',CONFIG_LANGUAGE)
                ->select('d.id as id','d.image as image','dd.title as title','dd.title as title','d.is_active as is_active')
                ->get();

		//$data = Discover::all();
		return view('Admin.content.discover.index')
								->with('data',$data)
								->with('view_title',$this->view_title)
								->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$languages = Language::all();
        return view('Admin.content.discover.create') ->with('languages',$languages)
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
        
        $validator = Validator::make($file, $rules,$messages);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('admin/cmgr/discover/create')->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/discover/'.$date_create; // upload path
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

                $discover = new Discover(array(  
                    'image' => $date_create.$fileName,
                    'is_active'   => $is_active
                ));

                // /dd($discover);
                $discover->save();
                $lastId = $discover->id;
                $langLen = sizeof($input['_language_id']);
                //dd($langLen);
                for($i=0;$i<$langLen;$i++){
                    $language_id = $input['_language_id'][$i];
                    $title = $input['title'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];
                    DB::table('discover_description')->insert(
                        [
                        'discover_id' => $lastId,
                        'language_id' => $language_id,
                        'title' => $title,
                        'description' => $description,
                        'meta_description' => $meta_description,
                        'meta_keywords' => $meta_keywords
                        ]
                    );
                }
 
               return redirect('admin/cmgr/discover')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/cmgr/discover/create')
                                ->with('message','Error while uploading!');
            }
        }

        
        
	}

	public function show($id)
	{
		$discover = Discover::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('discover','title',$id,$language_id);
            $description = $this->getDescription('discover','description',$id,$language_id);
            $meta_keywords = $this->getDescription('discover','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('discover','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.discover.show')->with('languages',$languages)
	                                         ->with('discover',$discover)
	                                         ->with('dataDes',$dataDes)
	                                         ->with('view_title',$this->view_title)
	                                         ->with('action',"View");
	}

	public function edit($id)
	{
		
		$discover = Discover::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('discover','title',$id,$language_id);
            $description = $this->getDescription('discover','description',$id,$language_id);
            $meta_keywords = $this->getDescription('discover','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('discover','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.discover.edit')->with('languages',$languages)
	                                         ->with('discover',$discover)
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
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/discover/'.$date_create; // upload path
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

             DB::table('discover')
                    ->where('id',$id)
                    ->update([
                        'image' => $date_create.$fileName
                    ]);
            }

            $discover = DB::table('discover')
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

                $query = DB::table('discover_description')->where('discover_id', $id)
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
                return redirect('admin/cmgr/discover')->with('message','Update Successfully');
	}

	public function destroy($id)
	{
		Discover::find($id)->delete();
		DB::table('discover_description')->where('discover_id', $id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
