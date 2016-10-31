<?php
namespace App\Http\Controllers\Admin;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Admin\Slide;
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

    class SlideController extends Controller {

    	public $view_title = "Slides";
    	public $view_sub_title = "Slides Listing";

    	public function __construct()
        {
           $this->middleware('auth');
           $menu_code = 's46';
           Session::flash('permissionOn_Menu_ID',$menu_code);
        }

    	public function index()
    	{	
            
    		//$data = Slide::all();
            $data = DB::table('slide as s')
                    ->leftjoin('slide_description as sd','s.id','=','sd.slide_id')
                    ->where('sd.language_id',CONFIG_LANGUAGE)
                    ->select('s.id as id','s.image as image','sd.title as title','s.is_active as is_active')
                    ->get();
    		return view('Admin.content.slide.index')
    								->with('data',$data)
    								->with('view_title',$this->view_title)
    								->with('view_sub_title',$this->view_sub_title);
    	}

        public function create()
        {   
            $languages = Language::all();
            return view('Admin.content.slide.create')->with('languages',$languages)
                                    ->with('view_title',$this->view_title)
                                    ->with('view_sub_title',$this->view_sub_title)
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
                return redirect('admin/cmgr/slide/create')->withErrors($validator);
            }
            else {
                // checking file is valid.
                if (Input::file('image')->isValid()) {
                    $image = $input['image'];
                    $date_create = date('d-M-Y/');
                    $destinationPath = 'images/uploads/slide/'.$date_create; // upload path
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

                    $slide = new Slide(array(  
                        'image' => $date_create.$fileName,
                        'is_active'   => $is_active
                    ));

                    $slide->save();
                    $lastId = $slide->id;
                    $langLen = sizeof($input['_language_id']);
                    //dd($langLen);
                    for($i=0;$i<$langLen;$i++){
                        $language_id = $input['_language_id'][$i];
                        $title = $input['title'][$i];
                        $sub_title = $input['sub_title'][$i];
                        $description = $input['description_'.$language_id];
                        $meta_keywords = $input['meta_keywords'][$i];
                        $meta_description = $input['meta_description'][$i];
                        DB::table('slide_description')->insert(
                            [
                            'slide_id' => $lastId,
                            'language_id' => $language_id,
                            'title' => $title,
                            'sub_title' => $sub_title,
                            'description' => $description,
                            'meta_description' => $meta_description,
                            'meta_keywords' => $meta_keywords
                            ]
                        );
                    }
     
                   return redirect('admin/cmgr/slide')->with('message','Save Successfully');
                }else {
                  // sending back with error message.
                  Session::flash('error', 'uploaded file is not valid');
                  //return Redirect::to('upload');
                  return redirect('admin/cmgr/cmgr/slide/create')
                                    ->with('message','Error while uploading!');
                }
            }

    	}

    	public function show($id)
    	{
            
    		$slide = Slide::find($id); 
            $languages = Language::all();  
            $dataDes = array();
            foreach ($languages as $lang){       
                $language_id = $lang->id;
                $title = $this->getDescription('slide','title',$id,$language_id);
                $sub_title = $this->getDescription('slide','sub_title',$id,$language_id);
                $description = $this->getDescription('slide','description',$id,$language_id);
                $meta_keywords = $this->getDescription('slide','meta_keywords',$id,$language_id);
                $meta_description = $this->getDescription('slide','meta_description',$id,$language_id);

                $dataDes[$language_id] = array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'description' => $description,
                    'meta_keywords'=>$meta_keywords,
                    'meta_description'=>$meta_description,
                    'language_id'=>$language_id
                );
            }

            return view('Admin.content.slide.show')->with('languages',$languages)
                                                 ->with('slide',$slide)
                                                 ->with('dataDes',$dataDes)
                                                 ->with('view_title',$this->view_title)
                                                 ->with('action',"Edition");
    	}

    	public function edit($id)
    	{
    		$slide = Slide::find($id); 
            $languages = Language::all();  
            $dataDes = array();
            foreach ($languages as $lang){       
                $language_id = $lang->id;
                $title = $this->getDescription('slide','title',$id,$language_id);
                $sub_title = $this->getDescription('slide','sub_title',$id,$language_id);
                $description = $this->getDescription('slide','description',$id,$language_id);
                $meta_keywords = $this->getDescription('slide','meta_keywords',$id,$language_id);
                $meta_description = $this->getDescription('slide','meta_description',$id,$language_id);

                $dataDes[$language_id] = array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'description' => $description,
                    'meta_keywords'=>$meta_keywords,
                    'meta_description'=>$meta_description,
                    'language_id'=>$language_id
                );
            }

            return view('Admin.content.slide.edit')->with('languages',$languages)
    	                                         ->with('slide',$slide)
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
            //dd(Input::file('image'));
            //mimes:jpeg,bmp,png and for max size max:10000
            // doing the validation, passing post data, rules and the messages
            //$validator = Validator::make($file, $rules);
            $picname = Input::file('image');
            //dd($picname);
            // checking file is valid.
            if ($picname!=""){
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/uploads/slide/'.$date_create; // upload path
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
                $image = $input['image'];
                DB::table('slide')
                        ->where('id',$id)
                        ->update([
                            'image'   => $date_create.$fileName
                        ]);
            }

                DB::table('slide')
                        ->where('id',$id)
                        ->update([
                            'is_active'=> $input['is_active']
                        ]);

                $langLen = sizeof($input['_language_id']);
                //dd($langLen);
                for($i=0;$i<$langLen;$i++){
                    $language_id = $input['_language_id'][$i];
                    $title = $input['title'][$i];
                    $sub_title = $input['sub_title'][$i];
                    $description = $input['description_'.$language_id];
                    $meta_keywords = $input['meta_keywords'][$i];
                    $meta_description = $input['meta_description'][$i];

                    $query = DB::table('slide_description')->where('slide_id', $id)
                                ->where('language_id', $language_id)
                                ->update(
                                    [
                                    'title' => $title,
                                    'sub_title' => $sub_title,
                                    'description' => $description,
                                    'meta_description' => $meta_description,
                                    'meta_keywords' => $meta_keywords
                                    ]
                                );
                }
                return redirect('admin/cmgr/slide')->with('message','Update Successfully');
            }

                // $input = $request->all();

                // $slide = Slide::find($id);
           
                // $slide->update($input);
                // 	//dd($test);
                //     $langLen = sizeof($input['_language_id']);
                //     //dd($langLen);
                //     for($i=0;$i<$langLen;$i++){
                //         $language_id = $input['_language_id'][$i];
                //         $title = $input['title'][$i];
                //         $sub_title = $input['sub_title'][$i];
                //         $description = $input['description_'.$language_id];
                //         $meta_keywords = $input['meta_keywords'][$i];
                //         $meta_description = $input['meta_description'][$i];

        		      //   $query = DB::table('slide_description')->where('slide_id', $id)
        		      //               ->where('language_id', $language_id)
        		      //               ->update(
        		      //                   [
                //                         'title' => $title,
                //                         'sub_title' => $sub_title,
        			     //                'description' => $description,
        			     //                'meta_description' => $meta_description,
        			     //                'meta_keywords' => $meta_keywords
        			     //                ]
                //                     );
                    	
                //     }

                //     //##########Set Event for ActivityLog############
                //     $eventName = 'Update';
                //     Session::flash('eventName',$eventName);
                //     $this->ActivityLog();
                //     return redirect('admin/cmgr/slide')->with('message','Update Successfully');
                
        	

        	public function destroy($id)
        	{
        		Slide::find($id)->delete();
        		DB::table('slide_description')->where('slide_id', $id)->delete();
        		return redirect()->back()->with('message','Deleted successfully');
        	}

        }
