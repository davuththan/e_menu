<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PositionRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\Position;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class PositionController extends Controller
{
	
	public $view_title = "Members <small> >> Position</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $positions = Position::all();
        return view('Admin.members.position.index')
                ->with('positions',$positions)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.members.position.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PositionRequest $request)
    {
        Position::create($request->all());
        return redirect("admin/members/position")->with('message',"Position => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Positions = Position::find($id);
        return view('Admin.members.position.form')->with('Positions',$Positions)
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
        $Positions = Position::find($id);
        return view('Admin.members.position.form')->with('Positions',$Positions)
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
    public function update(PositionRequest $request, $id)
    {
       $Position = Position::find($id);
       $Position->update($request->all());
       return redirect("admin/members/position")->with('message',"Position => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
