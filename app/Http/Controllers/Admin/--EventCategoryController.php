<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventCategoryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\EventCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class EventCategoryController extends Controller
{

    public $view_title = "Event Management <small> >> Event Category</small>";
    
    public function __construct()
    {

    }
    
    public function index()
    {   
        $EventCategory = EventCategory::all();
        return view('Admin.event_mgr.event_category.index')
                ->with('EventCategory',$EventCategory)
                ->with('view_title',$this->view_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        return view('Admin.event_mgr.event_category.form')
                                ->with('view_title',$this->view_title)
                                ->with('action',"Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        EventCategory::create($request->all());
        return redirect("admin/event_mgr/event_category")->with('message',"Event Category has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $EventCategorys = EventCategory::find($id);
        return view('Admin.event_mgr.event_category.form')
                    ->with('EventCategorys',$EventCategorys)
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
        $EventCategorys = EventCategory::find($id);
        return view('Admin.event_mgr.event_category.form')
                    ->with('EventCategorys',$EventCategorys)
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
    public function update(Request $request, $id)
    {
       $EventCategory = EventCategory::find($id);
       $EventCategory->update($request->all());

       return redirect("admin/event_mgr/event_category")->with('message',"Event Category has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        EventCategory::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
