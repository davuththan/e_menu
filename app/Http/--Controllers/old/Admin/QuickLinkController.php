<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\QuickLink;
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

class QuickLinkController extends Controller {

	public $view_title = "Quick Link";
	public $view_sub_title = "Quick Link Listing";

	public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's48';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
		//$data = QuickLink::all();
        $data = DB::table('quicklink as q')
                ->leftjoin('quicklink_description as qd','q.id','=','qd.quicklink_id')
                ->where('qd.language_id',CONFIG_LANGUAGE)
                ->select('q.id as id','q.url as url','q.thumbnail as thumbnail','qd.title as title','qd.title as title','q.is_active as is_active')
                ->get();

		return view('Admin.content.quick_link.index')
								->with('data',$data)
								->with('view_title',$this->view_title)
								->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$languages = Language::all();
        return view('Admin.content.quick_link.create') ->with('languages',$languages)
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
            return redirect('admin/cmgr/quick_link/create')->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/quick_link/'.$date_create; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                //$fileName = rand(11111,99999).'.'.$extension; // renameing image
                $fileName = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                $url = $input['url'];

                $quick_link = new QuickLink(array(
                	'thumbnail' => $date_create.$fileName,
                    'url'       => $thumbnail,
                    'is_active' => $is_active
                ));

                $quick_link->save();
                $lastId = $quick_link->id;
                $langLen = sizeof($input['_language_id']);
                //dd($langLen);
                for($i=0;$i<$langLen;$i++){
                    $language_id = $input['_language_id'][$i];
                    $title = $input['title'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];
                    DB::table('quicklink_description')->insert(
                        [
                        'quicklink_id' => $lastId,
                        'language_id' => $language_id,
                        'description' => $description,
                        'meta_description' => $meta_description,
                        'meta_keywords' => $meta_keywords
                        ]
                    );
                }

                //##########Set Event for ActivityLog############
                $eventName = 'create';
                Session::flash('eventName',$eventName);
                $this->ActivityLog();
                return redirect('admin/cmgr/quick_link')->with('message','Save Successfully');

            }else {
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/cmgr/cmgr/quick_link')
                                ->with('message','Error while uploading!');
            }
        }

	}

	public function show($id)
	{
		$quick_link = QuickLink::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('quicklink','title',$id,$language_id);
            $description = $this->getDescription('quicklink','description',$id,$language_id);
            $meta_keywords = $this->getDescription('quicklink','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('quicklink','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.quick_link.show')->with('languages',$languages)
	                                         ->with('quick_link',$quick_link)
	                                         ->with('dataDes',$dataDes)
	                                         ->with('view_title',$this->view_title)
	                                         ->with('action',"View");
	}

	public function edit($id)
	{
		
		$quick_link = QuickLink::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;
            $title = $this->getDescription('quicklink','title',$id,$language_id);
            $description = $this->getDescription('quicklink','description',$id,$language_id);
            $meta_keywords = $this->getDescription('quicklink','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('quicklink','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
            	'title' => $title,
            	'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.quick_link.edit')->with('languages',$languages)
	                                         ->with('quick_link',$quick_link)
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
        //dd($picname);
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/quick_link/'.$date_create; // upload path
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

             DB::table('quicklink')
                    ->where('id',$id)
                    ->update([
                        'thumbnail' => $date_create.$fileName
                    ]);
        }

        $quicklink = DB::table('quicklink')
                    ->where('id',$id)
                    ->update([
                        'url'   => $input['url'],
                        'is_active'   => $input['is_active']
                    ]);
    	//dd($test);
        $langLen = sizeof($input['_language_id']);
        //dd($langLen);
        for($i=0;$i<$langLen;$i++){
            $language_id = $input['_language_id'][$i];
            $title = $input['title'][$i];
            $description = $input['description_'.$language_id];
            $meta_keywords = $input['meta_keywords'][$i];
            $meta_description = $input['meta_description'][$i];

	        $query = DB::table('quicklink_description')->where('quicklink_id', $id)
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

        //##########Set Event for ActivityLog############
        $eventName = 'Update';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
        return redirect('admin/cmgr/quick_link')->with('message','Update Successfully');
        
	}

	public function destroy($id)
	{
		QuickLink::find($id)->delete();
		DB::table('quicklink_description')->where('quicklink_id', $id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
