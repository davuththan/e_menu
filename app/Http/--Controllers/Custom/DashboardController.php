<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GroupUser;
use App\Models\Project;
use App\Models\ProjectDes;
use App\Models\ProjectCategory;
use App\Models\ProjectCateogryDes;
use Carbon\Carbon;
use Setting;
use DB;
use Session;

class DashboardController extends Controller
{
	private $title = "Dashboard";
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $progress_project = DB::table('project')->where('project_status','=',0)->count();
        $complete_project = DB::table('project')->where('project_status','=',1)->count();
        $total_carrer = DB::table('career')
            ->join('career_description','career.id','=','career_description.career_id')
            ->select('career_description.job_title')
            ->count();
        $total_candidate = DB::table('candidate')->count();
        return view('bo.index',compact('data'))
                ->with('complete_project',$complete_project)
                ->with('progress_project',$progress_project)
                ->with('total_candidate',$total_candidate)
                ->with('total_carrer',$total_carrer)
        		->with('title',$this->title)
        		->with('action','');
    }

   
}
