<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Promotions;
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

class PromotionsController extends Controller {

	public $view_title = "Promotions";
	public $view_sub_title = "Promotions Listing";

	public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's47';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{	
        //$data = Slide::all();
        $data = DB::table('promotions as p')
                ->leftjoin('promotions_description as pd','p.id','=','pd.promotions_id')
                ->where('pd.language_id',CONFIG_LANGUAGE)
                ->select('p.id as id','p.image as image','pd.title as title','pd.title as title','p.is_active as is_active')
                ->get();

		return view('Admin.content.promotions.index')
								->with('data',$data)
								->with('view_title',$this->view_title)
								->with('view_sub_title',$this->view_sub_title);
	}

	public function create()
	{	
		$languages = Language::all();
        return view('Admin.content.promotions.create')  ->with('languages',$languages)
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
        //dd(Input::file('image'));
        //dd(Input::file('image'));
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules,$messages);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('admin/cmgr/promotions/create')->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/promotions/'.$date_create; // upload path
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

                $promotions = new Promotions(array(  
                    'image' => $date_create.$fileName,
                    'is_active'   => $is_active
                ));

                $promotions->save();
                $lastId = $promotions->id;
                $langLen = sizeof($input['_language_id']);

                $files = Input::file('image_large');
                // Making counting of uploaded images
                $file_count = count($files);
                // start count how many uploaded
                $uploadcount = 0;

                //if($files!=""){
                $i=0;
                $filename='';
                foreach($files as $file) {
                    if($file!=''){
                        $destinationPath = 'images/uploads/promotions/'.$date_create;
                        $filename = $file->getClientOriginalName();
                        $upload_success = $file->move($destinationPath, $filename);
                        $uploadcount ++;
                    }
                    $language_id = $input['_language_id'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];

                    DB::table('promotions_description')->insert(
                        [
                            'promotions_id' => $lastId,
                            'language_id' => $language_id,
                            'image' => $date_create.$filename,
                            'description' => $description,
                            'meta_description' => $meta_description,
                            'meta_keywords' => $meta_keywords
                        ]
                    );

                    $i++;
                }
                //}
 
               return redirect('admin/cmgr/promotions')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/cmgr/promotion/create')
                     ->with('message','Error while uploading!');
            }
        }
	}

	public function show($id)
	{
		$location = Location::lists('location','id');
        $promotions = Promotions::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;

            $image_data = $this->getDescription('promotions','image',$id,$language_id);
            $title = $this->getDescription('promotions','title',$id,$language_id);
            $description = $this->getDescription('promotions','description',$id,$language_id);
            $meta_keywords = $this->getDescription('promotions','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('promotions','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
                'title' => $title,
                'image' => $image_data,
                'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.promotions.show')->with('languages',$languages)
                                                 ->with('promotions',$promotions)
                                                 ->with('dataDes',$dataDes)
                                                 ->with('location',$location)
                                                 ->with('view_title',$this->view_title)
                                                 ->with('action',"View");
	}

	public function edit($id)
	{
		$location = Location::lists('location','id');
        $promotions = Promotions::find($id); 
        $languages = Language::all();  
        $dataDes = array();
        foreach ($languages as $lang) {         
            $language_id = $lang->id;

            $image_data = $this->getDescription('promotions','image',$id,$language_id);
            $title = $this->getDescription('promotions','title',$id,$language_id);
            $description = $this->getDescription('promotions','description',$id,$language_id);
            $meta_keywords = $this->getDescription('promotions','meta_keywords',$id,$language_id);
            $meta_description = $this->getDescription('promotions','meta_description',$id,$language_id);
            
            $dataDes[$language_id] = array(
                'title' => $title,
                'image' => $image_data,
                'description' => $description,
                'meta_keywords'=>$meta_keywords,
                'meta_description'=>$meta_description,
                'language_id'=>$language_id
            );
        }

        return view('Admin.content.promotions.edit')->with('languages',$languages)
                                                 ->with('promotions',$promotions)
                                                 ->with('dataDes',$dataDes)
                                                 ->with('location',$location)
                                                 ->with('view_title',$this->view_title)
                                                 ->with('action',"View");
		
	}

	public function update(Request $request, $id)
	{

        if(!$request->has('is_active')){
            $request->offsetSet('is_active','0');
        }
        $date_create = date('d-M-Y/');
        $input = $request->all();
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required'); 
        //dd(Input::file('image'));
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        //$validator = Validator::make($file, $rules);
        $picname = Input::file('image');
        //dd($picname);
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            
            $destinationPath = 'images/uploads/promotions/'.$date_create; // upload path
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

             DB::table('promotions')
                    ->where('id',$id)
                    ->update([
                        'image' => $date_create.$fileName
                    ]);
            }

            $promotions = DB::table('promotions')
                    ->where('id',$id)
                    ->update([
                        'is_active'   => $input['is_active']
                    ]);

            //###################
            $files = Input::file('image_large');
            // Making counting of uploaded images
            $file_count = count($files);
            // start count how many uploaded
            $uploadcount = 0;

            //if($files!=""){
            $i=0;
            $filename='';
            foreach($files as $file) {
                if($file!=''){
                    $language_id = $input['_language_id'][$i];
                    $destinationPath = 'images/uploads/promotions/'.$date_create;
                    $filename = $file->getClientOriginalName();
                    $upload_success = $file->move($destinationPath, $filename);
                    $uploadcount ++;

                    $query = DB::table('promotions_description')->where('promotions_id', $id)
                        ->where('language_id', $language_id)
                        ->update(
                            [
                            'image' => $date_create.$filename,
                            ]
                        );
                    $i++;

                }else{

                    $language_id = $input['_language_id'][$i];
                    $title = $input['title'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];

                    $query = DB::table('promotions_description')->where('promotions_id', $id)
                            ->where('language_id', $language_id)
                            ->update(
                            [
                                'title' => $title,
                                'description' => $description,
                                'meta_keywords'=>$meta_keywords,
                                'meta_description'=>$meta_description,
                            ]
                    );
                    $i++;        
                }
                
                
            }


            // $langLen = sizeof($input['_language_id']);
            // //dd($langLen);
            // for($i=0;$i<$langLen;$i++){
            //     $language_id = $input['_language_id'][$i];
            //     $title = $input['title'][$i];
            //     $description = $input['description_'.$language_id];
            //     $meta_keywords = $input['meta_keywords'][$i];
            //     $meta_description = $input['meta_description'][$i];

            //     $query = DB::table('promotions_description')->where('promotions_id', $id)
            //                 ->where('language_id', $language_id)
            //                 ->update(
            //                     [
            //                     'title' => $title,
            //                     'description' => $description,
            //                     'meta_keywords'=>$meta_keywords,
            //                     'meta_description'=>$meta_description,
            //                      ]
            //                 );
            // }
            return redirect('admin/cmgr/promotions')->with('message','Update Successfully');
	}


	public function destroy($id)
	{
		Promotions::find($id)->delete();
		\DB::table('promotions_description')->where('promotions_id', $id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
