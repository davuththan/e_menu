<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config\Language;
use App\Models\Content;
use App\Models\ContentDes;
use App\Models\Category;
use App\Models\CategoryDes;
use Input;
use Carbon\Carbon;
use Session;

class ContentController extends Controller
{
	private $title = "Content";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = Content::join('content_description',function ($join){
                    $join->on('content.id','=','content_description.content_id');
                    $join->where('content_description.language_id','=',CONFIG_LANGUAGE);
                })
                ->where('content.is_active',true)
                ->select('content.*','content_description.name')
                ->paginate(ITEM_PER_PAGE);
        return view('bo.content.list',compact('data'))
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
        $categories = Category::join('category_description',function($join){
                    $join->on('category.id','=','category_description.category_id');
                    $join->where('category_description.language_id','=',CONFIG_LANGUAGE);
                })
                ->lists('category_description.name','category.id');
            // dd($categories);
        $languages = Language::where('is_active',true)->get();
        return view('bo.content.detail')
                ->with('categories',$categories)
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
        $data = $request->all();
        
        $destinationPath = "images/upload/content/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }
        //save content
        $content = array(
                'image' => $fileName,
        		'category_id' => $data['category_id'],
                'is_active' =>true
        );
        $content = Content::create($content);
        //save content description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $content_des = array(
                'content_id' =>  $content->id,
                'language_id' => $language_id,
            	'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ContentDes::create($content_des);
        }
        $this->activityLog("create");
        return redirect('admin/cmgr/content')
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
        $entity = Content::find($id);
        $content_des = $entity->content_des;
        $languages = Language::where('is_active',true)->get();
        $categories = Category::join('category_description',function($join){
        	$join->on('category.id','=','category_description.category_id');
        	$join->where('category_description.language_id','=',CONFIG_LANGUAGE);
        })
        ->lists('category_description.name','category.id');
        return  view('bo.content.detail',compact('entity'))
                ->with('content_des',$content_des)
                ->with('categories',$categories)
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
        //
        $data = $request->all();
        //dd($data);
        $oldContent = Content::find($id);
        $destinationPath = "images/upload/content/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }else{
            $fileName = $oldContent->image;
        }
        //update career
        $content = array(
                'image' => $fileName,
        		'category_id' => $data['category_id'],
                //'is_active' =>true
        );
        
        $oldContent->update($content);
        foreach($oldContent->content_des as $content_des){
            $content_des->delete();
        }
        //update career description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $content_des = array(
                    'content_id' =>  $oldContent->id,
                    'language_id' => $language_id,
            		'name' => $data['name'][$language_id],
                    'description' => $data['description'][$language_id],
                    'meta_description' => $data['meta_description'][$language_id],
                    'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ContentDes::create($content_des);
        }
        $this->activityLog("update");
        return redirect('admin/cmgr/content')
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
        $content = Content::find($id);
        $content->update(['is_active'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
