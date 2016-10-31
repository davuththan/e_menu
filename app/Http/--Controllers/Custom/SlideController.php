<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config\Language;
use App\Models\Slide;
use App\Models\SlideImage;
use App\Models\SlideImageDes;
use App\Models\SlideMenu;
use App\Models\FMenuDes;
use App\Models\GroupUserDetail;
use Input;
use Carbon\Carbon;
use DB;
use Session;

class SlideController extends Controller
{
	private $title = "Slide";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
    	$data = Slide::where('is_active',true)->paginate(ITEM_PER_PAGE);
        return view('bo.slide.list',compact('data'))
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
        $menus =  array();
        $menuList = \DB::table('fmenu')
                ->join('fmenu_description','fmenu.id','=','fmenu_description.fmenu_id')
                ->select('fmenu.*','fmenu_description.name as menu_name')
                ->where('language_id',CONFIG_LANGUAGE)
                ->get();
        return view('bo.slide.detail',compact('menus','menuList'))
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
        // save slide
        $slide = array(
            'name'=> $data['name'],
            'is_active' =>true
        );
        $slide = Slide::create($slide);
       //save slide menu
       foreach($data['menu'] as $fmenu_id){
            $slidemenu = array(
                 'slide_id' => $slide->id,
                 'fmenu_id' =>$fmenu_id
            );
            SlideMenu::create($slidemenu);
        }
        $this->activityLog("create");
        return redirect('admin/cmgr/slide')
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
        $entity = Slide::find($id);
        $menus = SlideMenu::where('slide_id',$id)
                             ->lists('fmenu_id')->toArray();
        // dd($menus);
        $menuList = \DB::table('fmenu')
                ->join('fmenu_description','fmenu.id','=','fmenu_description.fmenu_id')
                ->select('fmenu.*','fmenu_description.name as menu_name')
                ->where('language_id',CONFIG_LANGUAGE)
                ->get();
         return view('bo.slide.detail',compact('entity','menus','menuList'))
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
         $oldSlide = Slide::find($id);
         $q = 'DELETE FROM tbl_slide_menu where slide_id = ?';
        \DB::delete($q, [$id]);
                                  
         $slide = array(
         	'name' => $request->input('name')	
         );
         // udpate slide
        $oldSlide->update($slide);

        //update slide menu
        foreach($data['menu'] as $fmenu_id){
            $slidemenu = array(
                 'slide_id' => $oldSlide->id,
                 'fmenu_id' =>$fmenu_id
            );
            SlideMenu::create($slidemenu);
        }
         $this->activityLog("update");
         return redirect('admin/cmgr/slide')
         ->with('message','Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide = Slide::find($id);
        $slide->update(['is_active'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
