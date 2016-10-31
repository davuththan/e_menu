<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GroupUser;

class GroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = GroupUser::get();
        return view('bo.groupuser.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bo.groupuser.detail');
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
        $entity = GroupUser::find($id);
        return view('bo.groupuser.detail',compact('entity'));
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
}
