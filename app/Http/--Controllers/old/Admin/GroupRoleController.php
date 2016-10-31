<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\GroupRole;
use App\Models\Admin\GroupRoleDetail;
use App\Models\Admin\GroupUser;
use Illuminate\Http\Request;

use DB;
use Validator;
use Auth;
use Session;
use Redirect;
use Input;

class GroupRoleController extends Controller {
	
	public $view_title = "Group Role";
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
    {
        $this->middleware('auth');

        //Assign All Menu Code For Permission
        $menu_code = 's03';
		\Session::flash('permissionOn_Menu_ID',$menu_code);
    }

    //Group Roles
	public function index()
	{
		//echo"testing";
		$allrole = GroupRole::all();
		
		//dd($allrole);
		
		return view('Admin.group_user.group_role_index')->with('allrole',$allrole);
		
		//return view('Admin.group_user.group_user_role_detail');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$group_user = GroupUser::lists('name','id');
		
		return view('Admin.group_user.group_role_create')->with('group_user',$group_user)
										    ->with('view_title',$this->view_title)
										    ->with('action',"Create");;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		 
		 GroupRole::create($input);

		 //##########Set Event for ActivityLog############
        $eventName = 'create';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();
		
		 return redirect('admin/user_mgr/group_role')->with('message','Save Successfully');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group_role = GroupRole::find($id);
		//echo $group_role->id;

		return view('Admin.group_user.group_role_permission')->with('group_role',$group_role);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function edit($id)
	{
		$group_user = GroupUser::lists('name','id');
		
		$group_role = GroupRole::find($id);
		
		return view('Admin.group_user.group_role_edit')->with('group_user',$group_user)
									  ->with('group_role',$group_role)
									  ->with('view_title',$this->view_title)
									  ->with('action',"Edition");
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$input = $request->all();
        $project = GroupRole::find($id);
        $project->update($input);

        //##########Set Event for ActivityLog############
        $eventName = 'update';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();

        return redirect(SITE_HTTP_URL.'admin/user_mgr/group_role');
	}
	
	public function updateGroupRolePermission(Request $request){

		if(!$request->has('chk_read')){
			$request->offsetSet('chk_read',"0");
		}

		//##########Set Event for ActivityLog############
        $eventName = 'update permission';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();

		// if(!$request->has('chk_read')){
		// 	$request->offsetSet('chk_read', "0");
		// }
		$data = $request->all();
        $id = $data['id'];
		
        $del_record = DB::table('group_role_detail')->where('group_role_id', '=', $id)->delete();

         if($del_record>=0){
			if (isset($data['menu_code']) && is_array($data['menu_code'])){
	        	//$j=1;
	        	foreach ( $data['menu_code'] as $key=>$value )
				{	
					$write_arr='';
					//Write
					if(!empty($data['chk_write'])){
						for($i=0;$i<count($data['chk_write']);$i++){
							if($data['menu_code'][$key]==$data['chk_write'][$i]){
								$write_arr =1;
								break;
								//echo $data['menu_code'][$key]."---Match---".$read_arr."<br/>";
							}else{
								$write_arr =0;
								//echo $data['menu_code'][$key]."---Not Match---0".$read_arr."<br/>";
							}
						}
					}else{
						$write_arr =0;
					}

					//Read
					for($i=0;$i<count($data['chk_read']);$i++){
						if($data['menu_code'][$key]==$data['chk_read'][$i]){
							$read_arr =1;
							break;
							//echo $data['menu_code'][$key]."---Match---".$read_arr."<br/>";
						}else{
							$read_arr =0;
							//echo $data['menu_code'][$key]."---Not Match---0".$read_arr."<br/>";
						}
					}

					

					DB::table('group_role_detail')->insert(
					    [
						'group_role_id' => intval($id), 
					  	'menu_code' => $data['menu_code'][$key],
					  	'menu_id' => $data['menu_id'][$key],
					  	'parent_menu_id' => $data['parent_menu_id'][$key],
					  	'read' => intval($read_arr),
					  	'write' => intval($write_arr)
					    ]
					);
				}

				return redirect('/admin/user_mgr/group_role')->with('message','Save Successfully');
				
			 }
         }else{
          	return redirect('/admin/user_mgr/group_role');
         }
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
		$data=GroupRole::find($id)->delete();
		return redirect()->back()->with('message','Deleted successfully');
	}

}
