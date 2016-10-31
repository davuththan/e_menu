<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberTypeRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\MemberType;

use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class MemberTypeController extends Controller
{
	
	public $view_title = "Members <small> >> Member Type</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $member_types = MemberType::all();
        return view('Admin.members.member_type.index')
                ->with('member_types',$member_types)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.members.member_type.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(MemberTypeRequest $request)
    {
        MemberType::create($request->all());
        return redirect("admin/members/member_type")->with('message',"Member Type => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $MemberTypes = MemberType::find($id);
        return view('Admin.members.member_type.form')->with('MemberTypes',$MemberTypes)
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
        $MemberTypes = MemberType::find($id);
        return view('Admin.members.member_type.form')->with('MemberTypes',$MemberTypes)
                                        ->with('view_title',$this->view_title)
                                        ->with('action',"Edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberTypeRequest $request, $id)
    {
       $MemberType = MemberType::find($id);
       $MemberType->update($request->all());
       return redirect("admin/members/member_type")->with('message',"Member Type => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MemberType::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
