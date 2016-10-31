<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MenuType;
use App\Models\FMenu;
use App\Models\FMenuDes;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use Validator;
use Session;
use DB;

class MenuTypeController extends Controller
{
    private $title = "Menu Type";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Session::set('menuCode', $this->getMenu());
        $data = MenuType::paginate(ITEM_PER_PAGE);
        return view('bo.menutype.list',compact('data'))
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
        //
        return view('bo.menutype.detail')
                    ->with('title',$this->title)
                    ->with('action','Create');;
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

        MenuType::create($input);
        $this->activityLog("create");                 
        return redirect('admin/menu_mgr/menu_type')->with('nmessage','Save Successfully');
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
        $entity = MenuType::find($id);
        return view('bo.menutype.detail',compact('entity'))
                ->with('title',$this->title)
                ->with('action','Edit');;
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
        $input = $request->all();
        $menutype_id = MenuType::find($id);
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }else{

        $menutype_id->update($input);
        $this->activityLog("update");            
        return redirect('admin/menu_mgr/menu_type')->with('nmessage','Save Successfully');
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
        $menutype = MenuType::find($id)->delete();
         return redirect('admin/menu_mgr/menu_type')->with('nmessage','Save Successfully');
    }
}
