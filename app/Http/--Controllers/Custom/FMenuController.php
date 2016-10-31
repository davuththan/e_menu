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
use DB;
use Session;

class FMenuController extends Controller
{
    private $title = "FMenu";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $allfmenu = DB::table('fmenu')
                    ->join('menu_type', 'menu_type.id', '=', 'fmenu.menu_type_id')
                    ->select('fmenu.*', 'menu_type.name as menu_type_name')
                    ->orderBy('fmenu.parent_id')
                    ->orderBy('fmenu.id')
                    ->get();
           //dd($allfmenu);
        $data = array();
        foreach ($allfmenu as $menu){
            $id = $menu->id;
            $menu_link = $menu->menu_link;
            $url = $menu->url;
            $ordering = $menu->ordering;
            $is_active = $menu->is_active;
            $manu_type_name = $menu->menu_type_name;

            $parent_id = $menu->parent_id;            
            $parent_name = '';
            if($parent_id>0) $parent_name =  $this->getFmenuDescription('name',$parent_id,CONFIG_LANGUAGE)." -> ";
            $menu_name = $this->getFmenuDescription('name',$id,CONFIG_LANGUAGE);
            //dd($menu_name);
            $data[] = array(
                'id'=>$menu->id,
                'menu_link'=>$menu_link,
                'url'=>$url,
                'ordering'=>$ordering,
                'is_active'=>$is_active,
                'menu_name'=>$parent_name.$menu_name,
                'manu_type_name'=>$manu_type_name
                
                );
        }

        return view('bo.fmenu.list')
                ->with('allfmenu',$data)
                ->with('title',$this->title)
                ->with('action','List');;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_type = MenuType::lists('name','id');
        $parentsList = DB::table('fmenu_description')
        ->where('language_id',CONFIG_LANGUAGE)
        ->select('fmenu_id', 'name')
        ->orderBy('name')
        ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            $parents[$pl->fmenu_id] = $pl->name;
        }
        // select language only is Active....
        $languages = Language::where('is_active',true)->get();
        
        return view('bo.fmenu.detail')
                        ->with('parents',$parents)
                        ->with('languages',$languages)
                        ->with('menu_type',$menu_type)
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
        //save fmenu
        $fmenu = array(
                'parent_id' => $data['parent_id'],
                'menu_type_id' => $data['menu_type_id'],
                'menu_link' => $data['menu_link'],  
                'url' => $data['url'],  
                'ordering' => $data['ordering'],
                'is_active' =>true
        );
        $fmenu = FMenu::create($fmenu);

       //save FMenu Description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $fmenu_des = array(
                'fmenu_id' =>  $fmenu->id,
                'language_id' => $language_id,
                'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id]
            );
            FMenuDes::create($fmenu_des);
        }
        $this->activityLog("create");
        return redirect('admin/menu_mgr/fmenu')
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
        $entity = FMenu::find($id);
        $menu_type = MenuType::lists('name','id');
         $parentsList = DB::table('fmenu_description')
            ->where('language_id',CONFIG_LANGUAGE)
            ->select('fmenu_id', 'name')
            ->orderBy('name')
            ->get();
        $parents = array();
        foreach ($parentsList as $pl) {
            $parents[$pl->fmenu_id] = $pl->name;
        }
        $fmenu_des = $entity->fmenu_des;     
        $languages = Language::where('is_active',true)->get();
        return  view('bo.fmenu.detail',compact('entity'))
                        ->with('fmenu_des',$fmenu_des)
                        ->with('parents',$parents)
                        ->with('menu_type',$menu_type)
                        ->with('languages',$languages)
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
        $oldFmenu = FMenu::find($id);
        // update Fmenu
        $fmenu = array(
                'parent_id' => $request->input('parent_id'),
                'menu_type_id' => $request->input('menu_type_id'),
                'menu_link' => $request->input('menu_link'),
                'url' => $request->input('url'),
                'ordering' => $request->input('ordering'),
                //'is_active' =>true
        );
        $oldFmenu->update($fmenu);
        foreach($oldFmenu->fmenu_des as $fmenu_des){
            $fmenu_des->delete();
        }
        //update Fmenu description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $fmenu_des = array(
                    'fmenu_id' =>  $oldFmenu->id,
                    'language_id' => $language_id,
                    'name' => $data['name'][$language_id],
                    'description' => $data['description'][$language_id],
                    'meta_description' => $data['meta_description'][$language_id],
                    'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            FMenuDes::create($fmenu_des);
        }
        $this->activityLog("update");
        return redirect('admin/menu_mgr/fmenu')
                ->with('message','Save Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $data=FMenu::find($id)->delete();
        return redirect()->back()->with('message','Deleted successfully');
    }
}
