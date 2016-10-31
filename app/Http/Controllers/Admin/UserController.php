<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\UserModel;
use App\Models\Admin\GroupUser;
// use App\user;
use DB;
use Validator;
use Auth;
use Session;
use DateTime;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{   
  
    public $view_title = "User";

  public function __construct()
    {
        $menu_code = 'y5_s17';
      Session::flash('menu_code',$menu_code);
    }

  public function index()
  { 

      $users = UserModel::all();
      //dd($users);
      return view('admin.user.index')
                ->with('view_title',$this->view_title)
                ->with('users',$users);
  }

  public function create()
  {  

    $group_user=GroupUser::lists('name','id');
    return view('admin.user.form')
                  ->with('group_user',$group_user)
                  ->with('action','create')
                  ->with('view_title',$this->view_title);
  }

  public function store(UserRequest $request)
  {

    $input = $request->all();
    // dd($input);
    $fileImage = "";
    if (Input::file('photo')!="") {
        $image = $input['photo'];
        $date_create = date('d-M-Y/');
        $destinationPath = 'images/upload/user/'.$date_create; // upload path
        $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
        //$fileName = rand(11111,99999).'.'.$extension; // renameing image
        $fileName = $image->getClientOriginalName();
        Input::file('photo')->move($destinationPath, $fileName); // uploading file to 
        // $input["photo"] = $fileName;
    }

      // UserModel::create($input);
      UserModel::create([
        'username' => Input::get('username'),
        'email' => Input::get('email'),
        'password' => bcrypt(Input::get('password')),
        'photo' => $date_create.'/'.$fileName,
        'group_id' => Input::get('group_id')
        //'emp_id' => Input::get('emp_id')
      ]);
      //##########Set Event for ActivityLog############
      $this->ActivityLog("create");
        
      return redirect("admin/user_mgr/user")->with('message','Save Successfully');
  }

  public function show($id)
  {
    $group_user = GroupUser::lists('name','id');
    $user = UserModel::find($id);
    
    return view('admin.user.form')->with('group_user',$group_user)
                        ->with('user',$user)
                        ->with('view_title',$this->view_title)
                        ->with('action',"show");
  }

  public function edit($id)
    {
      $group_user = GroupUser::lists('name','id');
      $user = UserModel::find($id);
      
      return view('admin.user.form')->with('group_user',$group_user)
                          ->with('user',$user)
                          ->with('view_title',$this->view_title)
                          ->with('action',"edit");

    
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        // dd($input);
        // getting all of the post data
        $file = array('photo' => Input::file('photo'));
        // setting up rules
        $rules = array('photo' => 'required'); 
        $picname = Input::file('photo');
        // checking file is valid.
        if($picname==''){
          if(empty($input['photo_hidden'])) $input['photo'] = null;
          else $input['photo'] = $input['photo_hidden'];
        }else{
          $image = $input['photo'];
          $date_create = date('d-M-Y/');
          $destinationPath = 'images/upload/user/'.$date_create; // upload path
          $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
          //$fileName = rand(11111,99999).'.'.$extension; // renameing image
          $fileName = $image->getClientOriginalName();
          Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
          
          //##########Set Event for ActivityLog############
          $this->ActivityLog('Updated');
          $input['photo']= $date_create.$fileName;
        }
        
        $project = UserModel::find($id);
        
        $old_pwd = $project->password;
        
        $rules = array(
            'group_id' => 'required',
            'username' => 'required',
              );
            // 'password' => 'confirmed|min:6',
            // 'email' => 'email|max:255|unique:user',
            // 'email' => 'email|max:255',
        
        $messages = [
            'group_id.required' => 'Choose group role!',
            'username.required' => 'Provide name!',
            // 'email.email' => 'Email is invalid!',
            // 'password.confirmed' => 'Password not match!',
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
            // dd('updated');
            //##########Set Event for ActivityLog############

            $this->ActivityLog('update');
            // return redirect()->back()->with('message','Update Successfully');
            
        }
        return redirect("admin/user_mgr/user")->with('message','Update Successfully');
        
    }
  public function destroy(Request $request,$id){
    //##########Set Event for ActivityLog############
    $this->ActivityLog('delete');
    //
    $data=UserModel::find($id)->delete();
    return redirect("admin/user_mgr/user")->with('message','Deleted Successfully');
    // return redirect()->back()->with('message','Deleted successfully');
  }
}   
