<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Admin\Permission;
use Validator;
use Auth;
use Session;
use Redirect;
use Input;

class PermissionController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $posts = Permission::all();
        return view('admin.permission.Permission_List',compact('posts'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create()
    {
      return view('admin.permission.PermissionSet_Role');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function store(PermissionRequest $request)
    { 
        $input = $request->all();
        Permission::create($input);

        //##########Set Event for ActivityLog############
        $eventName = 'create';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();

        return redirect('admin/permission/setPermission');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show(PermissionRequest $request,$id)
    {
      $permission = Permission::find($id);
      return view('admin.permission.PermissionSet_RoleEdit',compact('permission'));
    }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('admin.permission.PermissionSet_RoleEdit',compact('permission'));
    }

    /**
    * Update the specified resource in storage.
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    //public function update(Request $request, $id)
    public function update(PermissionRequest $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $project = Permission::find($id);
        $project->update($data);

        //##########Set Event for ActivityLog############
        $eventName = 'update';
        Session::flash('eventName',$eventName);
        $this->ActivityLog();

        return redirect('admin/permission/setPermission');
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
        $data=Permission::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }

}
