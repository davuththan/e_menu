<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusinessTypeRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\BusinessType;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class BusinessTypeController extends Controller
{
	
	public $view_title = "Members <small> >> Business Type</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $business_types = BusinessType::all();
        return view('Admin.members.business_type.index')
                ->with('business_types',$business_types)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.members.business_type.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(BusinessTypeRequest $request)
    {
        BusinessType::create($request->all());
        return redirect("admin/members/business_type")->with('message',"Business Type => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $BusinessTypes = BusinessType::find($id);
        return view('Admin.members.business_type.form')->with('BusinessTypes',$BusinessTypes)
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
        $BusinessTypes = BusinessType::find($id);
        return view('Admin.members.business_type.form')->with('BusinessTypes',$BusinessTypes)
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
    public function update(BusinessTypeRequest $request, $id)
    {
       $BusinessType = BusinessType::find($id);
       $BusinessType->update($request->all());
       return redirect("admin/members/business_type")->with('message',"Business Type => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BusinessType::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
