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

class ConfigController extends Controller
{
	private $title = "Configuration";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       Session::set('menuCode', $this->getMenu());
       $data = DB::table('config')
            ->join('config_group', 'config_group.id', '=', 'config.config_group_id')
            ->select('config.*', 'config_group.name as cg_name')
            ->orderBy('config_group.id', 'asc')
            ->paginate(ITEM_PER_PAGE);
        return view('bo.config.list',compact('data'))
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
        $config_group = ConfigGroup::lists('name','id')->all();
        return view('bo.config.detail',compact('config_group'))
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
        $data = $request->all();

        $config = array(
            'config_group_id'=> $data['config_group_id'],
            'name' => $data['name'],
            'keywords' => $data['keywords'],
            'value' => $data['value']
        );
        
        Config::create($config);
        $this->activityLog("create");
        return redirect('admin/setting/config')
            ->with('message','Save Successfully');   
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
        $entity = Config::find($id);
        $config_group = ConfigGroup::lists('name','id')->all();
        return view('bo.config.detail',compact('config_group','entity'))
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
       
        $data = $request->all();
        $oldConfig = Config::find($id);
        //update career
        $config = array(
            'config_group_id'=> $data['config_group_id'],
            'name' => $data['name'],
            'keywords' => $data['keywords'],
            'value' => $data['value'],
        );

        $oldConfig->update($config);
        $this->activityLog("update");
        return redirect('admin/setting/config')->with('message','Save Successfully');
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $config = Config::find($id)->delete();
        return redirect()->back()->with('message','Remove Successfully');
    }
}
