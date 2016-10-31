<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\ConfigGroup;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use DB;
use Validator;
use Auth;
use Session;
class ConfigGroupController extends Controller
{
	private $title = "Config Group";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = ConfigGroup::paginate(ITEM_PER_PAGE);
        return view('bo.configgroup.list',compact('data'))
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
       return view('bo.configgroup.detail')
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

        ConfigGroup::create($input);
        $this->activityLog("create");
        return redirect('admin/setting/config_group')->with('nmessage','Save Successfully');
        }       
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
        //
        $entity = ConfigGroup::find($id);
        return view('bo.configgroup.detail',compact('entity'))
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
        //
         $input = $request->all();
        
        $data = ConfigGroup::find($id);
        
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

        $data->update($input);
        $this->activityLog("update");
        return redirect('/admin/setting/config_group')->with('message','Save Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ConfigGroup::find($id)->delete();
        return redirect('/admin/setting/config_group')->with('message','Save Successfully');
    }
}
