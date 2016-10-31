<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseCountryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\BaseCountry;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class BaseCountryController extends Controller
{
	
	public $view_title = "Members <small> >> Base Country</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        
        $base_countrys = BaseCountry::all();

        return view('Admin.members.base_country.index')
                ->with('base_countrys',$base_countrys)
                ->with('view_title',$this->view_title);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.members.base_country.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(BaseCountryRequest $request)
    {
        BaseCountry::create($request->all());
        return redirect("admin/members/base_country")->with('message',"Base Country => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $BaseCountrys = BaseCountry::find($id);
        return view('Admin.members.base_country.form')->with('BaseCountrys',$BaseCountrys)
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
        $BaseCountrys = BaseCountry::find($id);
        return view('Admin.members.base_country.form')->with('BaseCountrys',$BaseCountrys)
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
    public function update(BaseCountryRequest $request, $id)
    {
       $BaseCountry = BaseCountry::find($id);
       $BaseCountry->update($request->all());
       return redirect("admin/members/base_country")->with('message',"Base Country => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BaseCountry::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
