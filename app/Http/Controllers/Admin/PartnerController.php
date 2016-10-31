<?php
namespace App\Http\Controllers\Admin;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Admin\Language;
    use App\Models\Admin\Partner;
    use App\Http\Requests\Admin\PartnerRequest;
    use DB;
    use App\user;
    use Validator;
    use Auth;
    use Session;
    use Input;
    use View;
    use Redirect;

    class PartnerController extends Controller {

    	public $view_title = "Design <small> >> Partners</small>";

    	public function __construct()
        {
           
        }

    	public function index()
    	{	
            
    		$partners = Partner::all();
    		return view('Admin.design.partner.index')
    								->with('partners',$partners)
    								->with('view_title',$this->view_title);
    	}

        public function create()
        {   
            return view('Admin.design.partner.form')
                                    ->with('view_title',$this->view_title)
                                    ->with('action',"Create");
        }


    	public function store(PartnerRequest $request)
    	{
        $input = $request->all();

        // getting all of the post data
        $data_validate = array('image' => Input::file('image'),'name'=>$input['name']);
        // setting up rules
        $rules = array('image' => 'required','name' => 'required'); 
        $messages = [
          'name.required' => 'Partner Name is required!',
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
                $destinationPath = 'images/upload/partner/'.$date_create; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                //$fileName = rand(11111,99999).'.'.$extension; // renameing image
                $fileName = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $fileName); // uploading 

                $image = $input['image'];

                DB::table('partner')->insert(
                    [
                        'name' => $input['name'],
                        'order_level'=>$input['order_level'],
                        'image' => $date_create.$fileName,
                        'url' => $input['url'],
                        'description' => $input['description']
                    ]
                );

                // Partner::create($request->all());
                 
               return redirect('admin/design/partner')->with('message','Save Successfully');
            }else {
              // sending back with error message.
              Session::flash('error', 'Problem while uploading file!');
              //return Redirect::to('upload');
              return redirect('admin/design/partner/create')
                                ->with('message','Error while uploading!');
            }
        }

    	}

    	public function show($id)
    	{
        $Partners = Partner::find($id);
        return view('Admin.design.partner.form')->with('view_title',$this->view_title)
                                                ->with('Partners',$Partners)
                                                ->with('action',"View");
    	}

    	public function edit($id)
    	{
    		$Partners = Partner::find($id);
        return view('Admin.design.partner.form')->with('view_title',$this->view_title)
                                                ->with('Partners',$Partners)
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
          'name.required' => 'Partner Name is required!',
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
            $destinationPath = 'images/upload/partner/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            //$fileName = rand(11111,99999).'.'.$extension; // renameing image
            $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading 

            $image = $input['image'];

            DB::table('partner')
            ->where('id',$id)
            ->update([
                'name' => $input['name'],
                'order_level'=>$input['order_level'],
                'url' => $input['url'],
                'image' => $date_create.$fileName,
                'description' => $input['description']
            ]);
             
          
          }else{
            DB::table('partner')
                ->where('id',$id)
                ->update([
                  'name' => $input['name'],
                  'order_level'=>$input['order_level'],
                  'url' => $input['url'],
                  'description' => $input['description']
                ]); 
          }
        }
        return redirect('admin/design/partner')->with('message','Update Successfully');
            
      }

    	public function destroy($id)
    	{
    		Partner::find($id)->delete();
    		return redirect()->back()->with('message','Deleted Successfully');
    	}

    }
