<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use Auth;
use Session;

class LanguageController extends Controller
{
	private $title = "Language";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Session::set('menuCode', $this->getMenu());
        $data = Language::where('is_active',true)->paginate(ITEM_PER_PAGE);
        return view('bo.language.list',compact('data'))
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
        $languages = Language::where('is_active',true)->get();
        return view('bo.language.detail')
                ->with('languages',$languages)
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
        //
        $data = $request->all();
        
        $destinationPath = "images/flag/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'images/flag/'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }
        //save language
        $language = array(
                'name' => $data['name'],
                'code' => $data['code'],
                'image' => $fileName,
                'is_active' =>true
        );
        $language = Language::create($language);
        $this->activityLog("create"); 
        return redirect('admin/cmgr/language')
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
        $entity = Language::find($id);
        return  view('bo.language.detail',compact('entity'))
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
        $data = $request->all();
        //dd($data);
        $oldLanguage = Language::find($id);
        $destinationPath = "images/flag/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'images/flag/'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }else{
            $fileName = $oldLanguage->image;
        }
        //update project
        $language = array(
                'image' => $fileName,
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                //'is_active' =>true
        );
        
        $oldLanguage->update($language);
        // dd($oldLanguage);
        $this->activityLog("update");
        return redirect('admin/cmgr/language')
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
        $language = Language::find($id);
        $language->update(['is_active'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
