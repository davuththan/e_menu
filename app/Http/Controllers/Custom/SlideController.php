<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config\Language;
use App\Models\Slide;
use App\Models\SlideDes;
use Input;
use Carbon\Carbon;
use DB;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Slide::join('slide_description',function ($join){
                    $join->on('slide.id','=','slide_description.slide_id');
                    $join->where('slide_description.language_id','=',CONFIG_LANGUAGE);
                })
                ->where('slide.is_active',true)
                ->select('slide.*','slide_description.title')
                ->paginate(ITEM_PER_PAGE);

        return view('bo.slide.list',compact('data'));
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
        return view('bo.slide.detail')
                ->with('languages',$languages);
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
        //dd($request->all());
        $data = $request->all();
        
        $destinationPath = "images/upload/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }
        //save slide
        $slide = array(
                'image' => $fileName,
                'is_active' =>true
        );

        $slide = Slide::create($slide);
        //save slide description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $slide_des = array(
                'slide_id' =>  $slide->id,
                'language_id' => $language_id,
                'title' => $data['title'][$language_id],
                'sub_title' => $data['sub_title'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            SlideDes::create($slide_des);
            
        }
        
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
        //
        $entity = Slide::find($id);
        $slide_des = $entity->slide_des;
        $languages = Language::where('is_active',true)->get();
        return  view('bo.slide.detail',compact('entity'))
                ->with('slide_des',$slide_des)
                ->with('languages',$languages);
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
          //
        $data = $request->all();
        //dd($data);
        $oldSlide = Slide::find($id);
        $destinationPath = "images/upload/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }else{
            $fileName = $oldSlide->image;
        }
        //update slide
        $slide = array(
                'image' => $fileName,
                //'is_active' =>true
        );
        
        $oldSlide->update($slide);
        foreach($oldSlide->slide_des as $slide_des){
            $slide_des->delete();
        }
        //update slide description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $slide_des = array(
                    'slide_id' =>  $oldSlide->id,
                    'language_id' => $language_id,
                    'title' => $data['title'][$language_id],
                    'sub_title' => $data['sub_title'][$language_id],
                    'description' => $data['description'][$language_id],
                    'meta_description' => $data['meta_description'][$language_id],
                    'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            SlideDes::create($slide_des);
        }
        
        return redirect('admin/cmgr/slide')
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
        //
       $slide = Slide::find($id);
       $slide->update(['is_active'=>false]);
       return redirect()->back()->with('message','Remove Successfully');
    }
}
