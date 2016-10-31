<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GroupUser;
use Carbon\Carbon;

class UserController extends Controller
{
	
	public function __construct(){
		$this->middleware('validator:App\Models\User',['only' => ['store']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::join('group_user','group_user.id','=','user.group_id')
       			-> where('user.is_active',true)
       			->select('user.username','user.email','user.id','group_user.name AS group')
        		->get();
        return view('bo.user.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$group_user = GroupUser::lists('name','id')->all();
    	return view('bo.user.detail',compact('group_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       //dd($request->all());
        $data = $request->all();
        
        $destinationPath = "images/upload/";
        $fileName = "";
        //upload image
        if($request->hasFile('photo')){
        	$extension = $request->file('photo')->getClientOriginalExtension();
        	$fileName = 'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
        	$request->file('photo')->move($destinationPath,$fileName);
        }
        
        $user = array(
        	'username'=> $data['username'],
        	'password'=> bcrypt($data['password']),
        	'email' => $data['email'],
        	'photo' => $fileName,
        	'group_id' => $data['group_id'],
        	'is_active' => true
        );
        
        User::create($user);
        return redirect('admin/user_mgr/user')
        		->with('message','Save Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = User::find($id);
        $group_user = GroupUser::lists('name','id')->all();
        return view('bo.user.detail',compact('group_user','entity'));
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
    	$data = $request->all();
    	//dd($data);
    	$oldUser = User::find($id);
    	$destinationPath = "images/upload/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('photo')){
    		$extension = $request->file('photo')->getClientOriginalExtension();
    		$fileName = 'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('photo')->move($destinationPath,$fileName);
    	}else{
    		$fileName = $oldUser->photo;
    	}
    	//update career
    	$user = array(
        	'username'=> $data['username'],
        	'email' => $data['email'],
        	'photo' => $fileName,
        	'group_id' => $data['group_id'],
        );
    	
    	if($data['password'] != ''){
    		$user['password']= bcrypt($data['password']);
    	}
    	 
    	$oldUser->update($user);
    	return redirect('admin/user_mgr/user')
    	->with('message','Save Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
