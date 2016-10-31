<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\UserModel;
//use App\Models\Admin\OriginOffice;
//use App\Models\Admin\Employee;
use App\Http\Requests\Admin\GroupUserRequest;
use App\Models\Admin\GroupUser;
use DB;
use Validator;
use Auth;
use Session;

class GroupUserController extends Controller {

	public $view_title = "Group User";
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	 public function __construct()
    {
       $this->middleware('auth');
       $menu_code = 's02';
       Session::flash('permissionOn_Menu_ID',$menu_code);
    }

	public function index()
	{
		$allgroup = GroupUser::all();
		
		return view('Admin.group_user.index')->with('allgroup',$allgroup);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$create_by = Session::get('permissionByMenuID');
		
		return view('Admin.group_user.create')->with('create_by',$create_by)
										    ->with('view_title',$this->view_title)
										    ->with('action',"Create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GroupUserRequest $request)
	{
		
		 $input = $request->all();
		 
		 //dd($input);
		 
		GroupUser::create($input);
		//##########Set Event for ActivityLog############
		$eventName = 'create';
		Session::flash('eventName',$eventName);
		$this->ActivityLog();
		
		 return redirect('admin/user_mgr/group_user')->with('message','Save Successfully');
		 
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		$group = GroupUser::find($id);
		
		$employee = Employee::lists('name','id');

		$user = UserModel::lists('username','id');
		
		return view('Admin.group_user.view')->with('group',$group)
									  ->with('user',$user)
									  ->with('view_title',$this->view_title)
									  ->with('action',"View");
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
		$group = GroupUser::find($id);
		
		return view('Admin.group_user.edit')->with('group',$group)
									  ->with('view_title',$this->view_title)
									  ->with('action',"Edition");

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(GroupUserRequest $request,$id)
	{
		
		$input = $request->all();
        $project = GroupUser::find($id);
        $project->update($input);

        //##########Set Event for ActivityLog############
        $eventName = 'update';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();

        return redirect('/admin/user_mgr/group_user')->with('message','Save Successfully');  
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//##########Set Event for ActivityLog############
        $eventName = 'delete';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
		//
		$data=GroupUser::find($id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}
}
