<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\UserModel;
use App\Models\Admin\GroupUser;
use Illuminate\Support\Facades\Input;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;
use View;

class UserController extends Controller
{
	
	public $view_title = "User";
	

    public function __construct()
    {
       $this->middleware('auth');
        //$this->middleware('guest');
       $menu_code = 's01';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	
        $alluser = UserModel::all();

        return view('Admin.user.index')->with('alluser',$alluser);

    }

    // public function SetRole()
    // {
    //     return view('admin.common.permissionControl');
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
        $group_user = GroupUser::lists('name','id');
		
        return view('Admin.user.create')->with('group_user',$group_user)
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

    //User Add
    public function add()
    {
        return view('Admin.user.user_form');
    }

    //User Permission
    public function user_permission()
    {
        return view('Admin.user.userPermission_list'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UserRequest $request)
    {
        
        $input = $request->all();
        
       //  $file = array('image' => Input::file('image'));
       //  $rules = array('image' => 'required'); 
       //  $messages = [
       //     'image.required' => 'Image is required!',
       // ];
        
       //  $validator = Validator::make($file, $rules,$messages);

        // if ($validator->fails()) {
        //     return redirect('admin/user_mgr/user/create')->withErrors($validator);
        // }
        // else {
            // checking file is valid.
        $fileImage = "";
        if (Input::file('image')!="") {
            if(Input::file('image')->isValid()){
              $image = $input['image'];
              $date_create = date('d-M-Y/');
              $destinationPath = 'images/uploads/user/'.$date_create; // upload path
              $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
              //$fileName = rand(11111,99999).'.'.$extension; // renameing image
              $fileName = $image->getClientOriginalName();
              Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

              $fileImage = $date_create.$fileName;
            }else{
              // sending back with error message.
              Session::flash('error', 'uploaded file is not valid');
              //return Redirect::to('upload');
              return redirect('admin/user_mgr/user')
                                ->with('message','Error while uploading!');
            }                         
        }
        //##########Set Event for ActivityLog############
        $eventName = 'create';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
    
        //UserModel::create($input);
    
        UserModel::create([
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => bcrypt(Input::get('password')),
                'photo' => $fileImage,
                'group_id' => Input::get('group_id')
                //'emp_id' => Input::get('emp_id')
        ]);
    
       return redirect('admin/user_mgr/user')->with('message','Save Successfully');
        //}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $group_user = GroupUser::lists('name','id');
        
        $user = UserModel::find($id);
        
        return view('Admin.user.view')//->with('employee',$employee)
									        //->with('origin',$origin)
									        ->with('group_user',$group_user)
									        ->with('user',$user)
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
        
        $group_user = GroupUser::lists('name','id');
        
        $user = UserModel::find($id);
        
        $user->password = '';
        
        return view('Admin.user.edit')->with('group_user',$group_user)
									        ->with('user',$user)
									        ->with('view_title',$this->view_title)
									        ->with('action',"Edition");
    
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

        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required'); 
        $picname = Input::file('image');
        
        // checking file is valid.
        if ($picname!=""){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/user/'.$date_create; // upload path
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

            DB::table('user')
                ->where('id',$id)
                ->update([
                    'photo'   => $date_create.$fileName
                    ]);
        }
        
        $project = UserModel::find($id);
        
        $old_pwd = $project->password;
        
        $rules = array(
            'username' => 'required',
            'password' => 'confirmed',
            'email' => 'email|max:255|unique:user',
            'group_id' => 'required');
        
        $messages = [
            'username.required' => 'Provide name!',
            'email.email' => 'Email is invalid!',
            'password.confirmed' => 'Password not match!',
            'group_id.required' => 'Choose group role!',
        ];
       $validator = Validator::make($input, $rules,$messages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

            if($input['password'] == ''){
                $input['password'] = $old_pwd;
                
            }else{
                $input['password'] = bcrypt($input['password']);
            }

            $project->update($input);
            //##########Set Event for ActivityLog############
            $eventName = 'update';
            Session::flash('eventName',$eventName);
            $this->ActivityLog();

            return redirect('/admin/user_mgr/user')->with('message','Update Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //##########Set Event for ActivityLog############
        $eventName = 'delete';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
        //
        $data=UserModel::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
