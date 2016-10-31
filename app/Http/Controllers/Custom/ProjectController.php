<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDes;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::where('project_status',true)
        ->orderBy('id','DESC')
        ->paginate(ITEM_PER_PAGE);
        return view('bo.project.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $languages = Language::where('is_active',true)->get();
        return view('bo.project.detail')
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
        //save project
        $project = array(
                'image' => $fileName,
                'project_start' => $data['project_start'],
                'project_end' => $data['project_end'],
                'project_status' =>true
        );
        $project = Project::create($project);
        //save Project description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $project_des = array(
                'project_id' =>  $project->id,
                'language_id' => $language_id,
                'name' => $data['name'][$language_id],
                'description' => $data['description'][$language_id],
                'location' => $data['location'][$language_id],
                'meta_description' => $data['meta_description'][$language_id],
                'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ProjectDes::create($project_des);
        }
        
        return redirect('admin/cmgr/project')
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
        //edit
        $entity = Project::find($id);
        // mdoel id
        $project_des = $entity->project_des;
        $languages = Language::where('is_active',true)->get();
        return  view('bo.project.detail',compact('entity'))
                ->with('project_des',$project_des)
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
        $oldProject = Project::find($id);
        $destinationPath = "images/upload/";
        $fileName = "";
        //upload image
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
            $request->file('image')->move($destinationPath,$fileName);
        }else{
            $fileName = $oldProject->image;
        }
        //update project
        $project = array(
                'image' => $fileName,
                'project_start' => $request->input('project_start'),
                'project_end' => $request->input('project_end'),
                //'is_active' =>true
        );
        
        $oldProject->update($project);
        foreach($oldProject->project_des as $project_des){
            $project_des->delete();
        }
        //update project description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
            $project_des = array(
                    'project_id' =>  $oldProject->id,
                    'language_id' => $language_id,
                    'name' => $data['name'][$language_id],
                    'description' => $data['description'][$language_id],
                    'location' => $data['location'][$language_id],
                    'meta_description' => $data['meta_description'][$language_id],
                    'meta_keywords' => $data['meta_keywords'][$language_id],
            );
            ProjectDes::create($project_des);
        }
        
        return redirect('admin/cmgr/project')
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
        $project = Project::find($id);
        $project->update(['project_status'=>false]);
        return redirect()->back()->with('message','Remove Successfully');
    }
}
