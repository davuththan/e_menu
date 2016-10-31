<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GroupUser;
use App\Models\GroupUserDetail;
use Session;

class GroupUserController extends Controller
{
	private $title = "Group User";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = GroupUser::get();
        return view('bo.groupuser.list',compact('data'))
        		->with('title',$this->title)
        		->with('action','List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bo.groupuser.detail')
        	->with('title',$this->title)
        		->with('action','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$groupUser = array(
    		'name' =>$request->input('name'),
    		'remark' =>$request->input('remark'),
    		'create_by_id' => Auth::user()->id
    	);
        GroupUser::create($groupUser);
        $this->activityLog("create");
        return redirect('admin/user_mgr/group_user')
        		->with('message','Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	/* $query = \DB::table('group_role_detail')
    	->join('group_user','group_user.id','=','group_role_detail.group_role_id')
    	->join('menu','menu.id','=','group_role_detail.menu_id')
    	->select('group_user.name','menu.menu_name','menu.id','menu.parent_id')
    	->where('group_user.id',$id)
    	->orderBy('menu.order_level');
    	$data = collect($query->get());
    	$menus = $data->groupBy('parent_id');*/
    	
    	$menus = GroupUserDetail::where('group_role_id',$id)
    			             ->lists('menu_id')->toArray();
    	
    	$queryMenu = \DB::table('menu')
    					->orderBy('order_level');
    	$menuData =	collect($queryMenu->get());
    	$menuList = $menuData->groupBy('parent_id');
    	//dd($menuList);
    	return view('bo.groupuser.permission',compact('menus','menuList'))
    		      ->with('group_user_id',$id)
                  ->with('title',$this->title)
                  ->with('action','Show');;
    	//dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = GroupUser::find($id);
        return view('bo.groupuser.detail',compact('entity'))
        		->with('title',$this->title)
        		->with('action','Edit');
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
    	$oldGroupUser = GroupUser::find($id);
    	$groupUser = array(
    			'name' =>$request->input('name'),
    			'remark' =>$request->input('remark')
    	);
    	$oldGroupUser->update($groupUser);
        $this->activityLog("update");
    	return redirect('admin/user_mgr/group_user')
    	->with('message','Saved Successfully');
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
    
    public function permission(Request $request){
    	//dd($request->all());
    	$data = $request->all();
    	
    	$old_group_detail_list = GroupUserDetail::where('group_role_id',$data['group_user_id'])
    			             ->get();
    	foreach($old_group_detail_list as $detail){
    		$detail->delete();
    	}
    	
    	foreach($data['menu'] as $menu_id){
    		$groupdetail = array(
    				'group_role_id' => $data['group_user_id'],
    				'menu_code' => 'unused',
    				'menu_id' =>$menu_id,
    				'read' =>true,
    				'write' =>true
    		);
    		GroupUserDetail::create($groupdetail);
    	}
    	
    	return redirect('admin/user_mgr/group_user')
    	->with('message','Saved Successfully');
    	
    }
}
