<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsefulLinkRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\UsefulLink;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class UsefulLinkController extends Controller
{
	
	public $view_title = "Link <small> >> Useful Link</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $useful_links    = UsefulLink::all();
        return view('Admin.useful_link.index')
                ->with('useful_links',$useful_links)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.useful_link.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UsefulLinkRequest $request)
    {
        UsefulLink::create($request->all());
        return redirect("admin/link/useful_link")->with('message',"Useful Link => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $useful_links    = UsefulLink::find($id);
        return view('Admin.useful_link.form')->with('useful_links   ',$useful_links    )
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
        $useful_links = UsefulLink::find($id);
        return view('Admin.useful_link.form')->with('useful_links',$useful_links)
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
    public function update(UsefulLinkRequest $request, $id)
    {
       $UsefulLink = UsefulLink::find($id);
       $UsefulLink->update($request->all());
       return redirect("admin/link/useful_link")->with('message',"Useful Link => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UsefulLink::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
