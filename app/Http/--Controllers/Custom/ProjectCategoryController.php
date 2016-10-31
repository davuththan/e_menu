<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Config\Language;
use App\Models\ProjectCategory;
use App\Models\ProjectCateogryDes;
use Input;
use Carbon\Carbon;
use DB;
use Session;

class ProjectCategoryController extends Controller
{
	private $title = "Project Category";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = ProjectCategory::join('project_category_description',function ($join){
                    $join->on('project_category.id','=','project_category_description.project_category_id');
                    $join->where('project_category_description.language_id','=',CONFIG_LANGUAGE);
                })
                ->where('project_category.is_active',true)
                ->select('project_category.*','project_category_description.name','project_category_description.description')
                ->paginate(ITEM_PER_PAGE);
        return view('bo.projectcategory.list',compact('data'))
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
        return view('bo.projectcategory.detail')
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
        
        $destinationPath = "images/upload/project/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }
        //save projectcategory
        $projectcategory = array(
                'image' => $fileName,
                'is_active' =>true
        );
        $projectcategory = ProjectCategory::create($projectcategory);
        //save career description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $project_category_des = array(
                'project_category_id' =>  $projectcategory->id,
                'language_id' => $language_id,
                'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ProjectCateogryDes::create($project_category_des);
        }
        $this->activityLog("create");
        return redirect('admin/cmgr/project_category')
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
        $entity = ProjectCategory::find($id);
        $project_category_des = $entity->project_category_des;
        $languages = Language::where('is_active',true)->get();
        return  view('bo.projectcategory.detail',compact('entity'))
                ->with('project_category_des',$project_category_des)
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
        $oldProjectCategory = ProjectCategory::find($id);
        $destinationPath = "images/upload/project/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }else{
            $fileName = $oldProjectCategory->image;
        }
        //update project category
        $projectcategory = array(
                'image' => $fileName
                //'is_active' =>true
        );
        
        $oldProjectCategory->update($projectcategory);
        foreach($oldProjectCategory->project_category_des as $project_category_des){
            $project_category_des->delete();
        }
        //update Category Description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $project_category_des = array(
                'project_category_id' =>  $oldProjectCategory->id,
                'language_id' => $language_id,
                'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ProjectCateogryDes::create($project_category_des);
        }
        $this->activityLog("update");
        return redirect('admin/cmgr/project_category')
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
        $projectcategory = ProjectCategory::find($id);
        $projectcategory->update(['is_active'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
