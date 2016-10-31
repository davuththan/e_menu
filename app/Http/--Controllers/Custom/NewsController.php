<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsDes;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use DB;
use Session;

class NewsController extends Controller
{
	private $title = "News";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = News::join('news_description',function($join){
            $join->on('news.id','=','news_description.news_id');
            $join->where('news_description.language_id','=',CONFIG_LANGUAGE);
        })
        ->where('news.is_active',true)
        ->select('news.*','news_description.name','news_description.description')
        ->paginate(ITEM_PER_PAGE);
        return view('bo.news.list',compact('data'))
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
        return view('bo.news.detail')
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
        
        //upload image
        $destinationPath = "images/upload/news/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
        	$extension = $request->file('image')->getClientOriginalExtension();
        	$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
        	$request->file('image')->move($destinationPath,$fileName);
        }
        //save news
        $news = array(
            'published_date' => $data['published_date'],
            'is_active' =>true,
        	'image' => $fileName
        );
        $news = News::create($news);

        // save Description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $news_des = array(
                'news_id' =>  $news->id,
                'language_id' => $language_id,
                'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            NewsDes::create($news_des);
        }
        $this->activityLog("create");
        return redirect('admin/cmgr/news')
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
        $entity = News::find($id);
        $news_des = $entity->news_des;
        $languages = Language::where('is_active',true)->get();
        return  view('bo.news.detail',compact('entity'))
                ->with('news_des',$news_des)
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
        $oldNew = News::find($id);
        $destinationPath = "images/upload/news/";
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
        $news = array(
                'published_date' => $request->input('published_date'),
        		'image' => $fileName
                //'is_active' =>true
        );
        
        $oldNew->update($news);
        foreach($oldNew->news_des as $news_des){
            $news_des->delete();
        }

        //update news description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $news_des = array(
                    'news_id' =>  $oldNew->id,
                    'language_id' => $language_id,
                    'name' => $data['name'][$language_id],
                    'description' => $data['description'][$language_id],
                    'meta_description' => $data['meta_description'][$language_id],
                    'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            NewsDes::create($news_des);
        }
        $this->activityLog("update");
        return redirect('admin/cmgr/news')
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
        $news = News::find($id);
        $news->update(['is_active'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
