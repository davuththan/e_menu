<?php
namespace App\Http\Controllers\Admin;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Admin\Language;
    use App\Models\Admin\Committee;
    use App\Http\Requests\Admin\CommitteeRequest;
    use DB;
    use App\user;
    use Validator;
    use Auth;
    use Session;
    use Input;
    use View;
    use Redirect;

    class CommitteeController extends Controller {

    	public $view_title = "Information <small> >> Committee</small>";

    	public function __construct()
        {
           
        }

    	public function index()
    	{	
            
    		$committees = Committee::all();
    		return view('Admin.information.committee.index')
    								->with('committees',$committees)
    								->with('view_title',$this->view_title);
    	}

        public function create()
        {   
            return view('Admin.information.committee.form')
                                    ->with('view_title',$this->view_title)
                                    ->with('action',"Create");
        }


    	public function store(CommitteeRequest $request)
    	{
        $input = $request->all();

        // getting all of the post data
        $data_validate = array('image' => Input::file('image'),'name'=>$input['name']);
        // setting up rules
        $rules = array('image' => 'required','name' => 'required'); 
        $messages = [
          'name.required' => 'Committee is required!',
          'image.required' => 'Image is required!',
       ];
        //dd(Input::file('image'));
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($data_validate, $rules,$messages);
        if ($validator->fails()) {
          // send back to the page with the input data and errors
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $image = $input['image'];
                $date_create = date('d-M-Y/');
                $destinationPath = 'images/upload/committee/'.$date_create; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                //$fileName = rand(11111,99999).'.'.$extension; // renameing image
                $fileName = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $fileName); // uploading 

                $image = $input['image'];

                DB::table('committee')->insert(
                    [
                        'name' => $input['name'],
                        'image' => $date_create.$fileName,
                        'position' => $input['position'],
                        'company' => $input['company'],
                        'contact' => $input['contact'],
                        'email' => $input['email'],
                        'order_level'=>$input['order_level'],
                    ]
                );

                // Committee::create($request->all());
                 
               return redirect('admin/information/committee')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'Problem while uploading file!');
              //return Redirect::to('upload');
              return redirect('admin/information/committee/create')
                                ->with('message','Error while uploading!');
            }
        }

    	}

    	public function show($id)
    	{
        $Committees = Committee::find($id);
        return view('Admin.information.committee.form')->with('view_title',$this->view_title)
                                                ->with('Committees',$Committees)
                                                ->with('action',"View");
    	}

    	public function edit($id)
    	{
    		$Committees = Committee::find($id);
        return view('Admin.information.committee.form')->with('view_title',$this->view_title)
                                                ->with('Committees',$Committees)
    	                                          ->with('action',"Edit");
    		
    	}


    	public function update(Request $request, $id)
    	{

        $input = $request->all();

        // getting all of the post data
        $data_validate = array('name'=>$input['name']);
        // setting up rules
        $rules = array('name' => 'required'); 
        $messages = [
          'name.required' => 'Committee is required!',
       ];
        //dd(Input::file('image'));
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($data_validate, $rules,$messages);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
          return redirect()->back()->withInput()->withErrors($validator);
        }else {
          if (Input::file('image')!="") {
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/upload/committee/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            //$fileName = rand(11111,99999).'.'.$extension; // renameing image
            $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading 

            $image = $input['image'];

            DB::table('committee')
            ->where('id',$id)
            ->update([
                'name' => $input['name'],
                'image' => $date_create.$fileName,
                'position' => $input['position'],
                'company' => $input['company'],
                'contact' => $input['contact'],
                'email' => $input['email'],
                'order_level'=>$input['order_level'],
            ]);
             
          
          }else{
            DB::table('committee')
                ->where('id',$id)
                ->update([
                    'name' => $input['name'],
                    'position' => $input['position'],
                    'company' => $input['company'],
                    'contact' => $input['contact'],
                    'email' => $input['email'],
                    'order_level'=>$input['order_level'],
                ]); 
          }
        }
        return redirect('admin/information/committee')->with('message','Update Successfully');
            
      }

    	public function destroy($id)
    	{
    		Committee::find($id)->delete();
    		return redirect()->back()->with('message','Deleted Successfully');
    	}

    }
