<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Models\SlideImage;
use App\Models\SlideImageDes;
use App\Models\Config\Language;

use Carbon\Carbon;

class SlideImageController extends Controller
{
	private $title = "Slide Image";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/* $data = Category::join('category_description',function ($join){
    				$join->on('category.id','=','category_description.category_id');
    				$join->where('category_description.language_id','=',CONFIG_LANGUAGE);
    			})
    			->where('category.is_active',true)
    			->select('category.*','category_description.name')
    			->paginate(ITEM_PER_PAGE);

    	return view('bo.category.list',compact('data')); */
    	//dd($id);
    }
    
    public function getSlideImage($id){
    	//dd($id);
    	$data = SlideImage::where('slide_id',$id)
    			->get();
    	return view('bo.slideimage.list',compact('data'))
    			->with('slideId',$id)
    			->with('title',$this->title)
        		->with('action','List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSlideImage($id)
    {
    	$languages = Language::where('is_active',true)->get();
    	$slide = Slide::find($id);
    	return view('bo.slideimage.detail')
    			->with('slide',$slide)
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
    	//dd($request->all());
    	$data = $request->all();
    	 
    	$destinationPath = "images/upload/slide/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}
    	//save category
    	$slideImage = array(
    			'image' => $fileName,
    			'slide_id' =>$data['slide_id']
    	);
    	$slideImage = SlideImage::create($slideImage);
    	//save category description
    	foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
    		$slideImageDes = array(
    				'slide_image_id' => $slideImage->id,
    				'language_id' => $language_id,
    				'title' => $data['title'][$language_id],
    				'sub_title' => $data['sub_title'][$language_id],
    				'description' => $data['description'][$language_id],
    				'meta_description' => $data['meta_description'][$language_id],
    				'meta_keywords' => $data['meta_keywords'][$language_id],
    		);
    		SlideImageDes::create($slideImageDes);
    	}
    	
    	return redirect('admin/cmgr/slideimage/get_slide_image/'.$data['slide_id'])
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
    	$entity = SlideImage::find($id);
    	$slide = Slide::find($entity->slide_id);
    	$slide_image_des = $entity->slide_image_des; 
    	$languages = Language::where('is_active',true)->get();
    	return  view('bo.slideimage.detail',compact('entity'))
    	->with('slide',$slide)
    	->with('slide_image_des',$slide_image_des)
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
    	$oldSlideImage = SlideImage::find($id);
    	$destinationPath = "images/upload/slide/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}else{
    		$fileName = $oldSlideImage->image;
    	}
    	//update category
    	$slideImage = array(
    			'image' => $fileName,
    	);
    	 
    	$oldSlideImage->update($slideImage);
    	foreach($oldSlideImage->slide_image_des as $slide_image_des){
    		$slide_image_des->delete();
    	}
    	//update category description
    	foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
    		$slide_image_des = array(
    				'slide_image_id' => 	$oldSlideImage->id,
    				'language_id' => $language_id,
    				'title' => $data['title'][$language_id],
    				'sub_title' => $data['sub_title'][$language_id],
    				'description' => $data['description'][$language_id],
    				'meta_description' => $data['meta_description'][$language_id],
    				'meta_keywords' => $data['meta_keywords'][$language_id],
    		);
    		SlideImageDes::create($slide_image_des);
    	}
    	 
    	return redirect('admin/cmgr/slideimage/get_slide_image/'.$data['slide_id'])
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
    	$slideImage = SlideImage::find($id);
    	$slideImage->delete();
    	return redirect()->back()->with('message','Remove Successfully');
    }
}
