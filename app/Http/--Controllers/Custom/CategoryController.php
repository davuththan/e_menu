<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryDes;
use App\Models\Config\Language;
use Carbon\Carbon;
use Input;
use Session;
class CategoryController extends Controller
{
	private $title = "Category";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
    	$data = Category::join('category_description',function ($join){
    				$join->on('category.id','=','category_description.category_id');
    				$join->where('category_description.language_id','=',CONFIG_LANGUAGE);
    			})
    			->where('category.is_active',true)
    			->select('category.*','category_description.name')
    			->paginate(ITEM_PER_PAGE);

    	return view('bo.category.list',compact('data'))
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
    	$languages = Language::where('is_active',true)->get();
    	return view('bo.category.detail')
    			->with('languages',$languages)
    			->with('title',$this->title)
        		->with('action','Edit');
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
    	 
    	$destinationPath = "images/upload/category/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}
    	//save category
    	$category = array(
    			'image' => $fileName,
    			'is_active' =>true
    	);
    	$category = Category::create($category);
    	//save category description
    	foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
    		$category_des = array(
    				'category_id' => 	$category->id,
    				'language_id' => $language_id,
    				'name' => $data['name'][$language_id],
    				'description' => $data['description'][$language_id],
    				'meta_description' => $data['meta_description'][$language_id],
    				'meta_keywords' => $data['meta_keywords'][$language_id],
    		);
    		CategoryDes::create($category_des);
    	}
    	$this->activityLog("create");
    	return redirect('admin/cmgr/category')
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
    	$entity = Category::find($id);
    	$category_des = $entity->category_des;
    	$languages = Language::where('is_active',true)->get();
    	return  view('bo.category.detail',compact('entity'))
    	->with('category_des',$category_des)
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
    	//dd($data);
    	$oldCategory = Category::find($id);
    	$destinationPath = "images/upload/category/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}else{
    		$fileName = $oldCategory->image;
    	}
    	//update category
    	$category = array(
    			'image' => $fileName,
    			//'is_active' =>true
    	);
    	 
    	$oldCategory->update($category);
    	foreach($oldCategory->category_des as $category_des){
    		$category_des->delete();
    	}
    	//update category description
    	foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
    		$category_des = array(
    				'category_id' => 	$oldCategory->id,
    				'language_id' => $language_id,
    				'name' => $data['name'][$language_id],
    				'description' => $data['description'][$language_id],
    				'meta_description' => $data['meta_description'][$language_id],
    				'meta_keywords' => $data['meta_keywords'][$language_id],
    		);
    		CategoryDes::create($category_des);
    	}
    	$this->activityLog("update");
    	return redirect('admin/cmgr/category')
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
    	$category = Category::find($id);
    	$category->update(['is_active'=>false]);
    	return redirect()->back()->with('message','Remove Successfully');
    }
}
