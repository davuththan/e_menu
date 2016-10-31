<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsefulInfoCategoryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\UsefulInfoCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class UsefulInfoCategoryController extends Controller
{
	
	public $view_title = "Useful Information <small> >> Useful Info Category</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $useful_categorys = UsefulInfoCategory::all();
        return view('Admin.useful_information.useful_category.index')
                ->with('useful_categorys',$useful_categorys)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.useful_information.useful_category.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UsefulInfoCategoryRequest $request)
    {
        UsefulInfoCategory::create($request->all());
        return redirect("admin/useful_information/useful_category")->with('message',"Useful Category => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $UsefulInfoCategorys = UsefulInfoCategory::find($id);
        return view('Admin.useful_information.useful_category.form')
                                        ->with('UsefulInfoCategorys',$UsefulInfoCategorys)
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
        $UsefulInfoCategorys = UsefulInfoCategory::find($id);
        return view('Admin.useful_information.useful_category.form')
                                        ->with('UsefulInfoCategorys',$UsefulInfoCategorys)
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
    public function update(UsefulInfoCategoryRequest $request, $id)
    {
       $UsefulInfoCategory = UsefulInfoCategory::find($id);
       $UsefulInfoCategory->update($request->all());
       return redirect("admin/useful_information/useful_category")->with('message',"Useful Category => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UsefulInfoCategory::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
