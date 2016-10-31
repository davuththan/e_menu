<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ProjectDes;
use App\Models\ProjectCategory;
use App\Models\ProjectCateogryDes;
use DB;
use Auth;
use Session;
use App;

class FoController extends Controller
{
	public function __construct(){
		$this->middleware('config');
        // date_default_timezone_set('Asia/Phnom_Penh');
        // $languages = DB::table('language')->get();
        $language_id = Session::get('applangId');
        if($language_id==1){
          App::setLocale('kh');
        }else if($language_id==2){
          App::setLocale('en');
        }else{
            App::setLocale('en');
            Session::set('applangId',2);
        }

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        return view('fo.index')
                ->with('slide_image',$collect_slide);
    }
    // members
    public function members(){
        return view('fo.members');
    }
    // About
    public function about(){
        return view('fo.about');
    }
    // Contact
    public function contact(){
        return view('fo.contact');
    }
    public function event_news(){
        return view('fo.event_news');
    }
    // Event and New
    public function event_news1(){

        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        
        $all_news = DB::table('news')
	        ->join('news_description AS news_des',function($join){
	        	$join->on('news.id','=','news_des.news_id');
	        	$join->where('news_des.language_id','=',Session::get('applangId'));
	        })
	        ->where('news.is_active',true)
	        ->select('news.id','news.published_date','news.image','news_des.name','news_des.description')
	        ->get()
	        ;
        return view("fo.event_news")
        ->with('all_news',$all_news)
        ->with('slide_image',$collect_slide);
    }
    //event news detail
    public function event_news_detail($id){
    	$news = DB::table('news')
	        ->join('news_description AS news_des',function($join){
	        	$join->on('news.id','=','news_des.news_id');
	        	$join->where('news_des.language_id','=',Session::get('applangId'));
	        })
	        ->where('news.id',$id)
	        ->select('news.published_date','news.image','news_des.name','news_des.description')
	        ->first();
    					 
    					$menu_id=1;
    					$collect_slide = $this->getSlideByMenu($menu_id);
    					return view("fo.event_news_detail")
    					->with('news',$news)
    					->with('slide_image',$collect_slide);
    }
    // gallery
    public function gallery(){

        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        //project category
        $project_categories = DB::table('project_category AS cat')
        ->join('project_category_description AS cat_des',function($join){
        	$join->on('cat.id','=','cat_des.project_category_id');
        	$join->where('cat_des.language_id','=',Session::get('applangId'));
        })
        ->where('cat.is_active',true)
        ->select('cat.id','cat_des.name')
        ->get();
        
        //	all project
        $projects = DB::table('project AS p')
        ->join('project_description AS p_des',function($join){
        	$join->on('p.id','=','p_des.project_id');
        	$join->where('p_des.language_id','=',Session::get('applangId'));
        })
        ->join('project_category AS cat','cat.id','=','p.project_category_id')
        ->join('project_category_description AS cat_des',function($join){
        	$join->on('cat.id','=','cat_des.project_category_id');
        	$join->where('cat_des.language_id','=',Session::get('applangId'));
        })
        ->where('p.project_status',1)
        ->select('p.id','p.image','cat.id AS cat_id','cat_des.name AS cat_name',
        		'p.project_start','p_des.name','p_des.location')
        		->get();
        
        return view("fo.gallery")
        ->with('slide_image',$collect_slide)
        ->with('projects',$projects)
        ->with('project_categories',$project_categories);
    }
    //project_detail
    public function project_detail($id){
    	//detail this project
    	$project = DB::table('project AS p')
        			->join('project_description AS p_des',function($join){
        				$join->on('p.id','=','p_des.project_id');
        				$join->where('p_des.language_id','=',Session::get('applangId'));
        			})
        			->where('p.id',$id)
        			->where('p.project_status',1)
        			->select('p.project_start','p.project_end','p_des.name',
        					'p_des.description','p_des.location')
        			->first();
        //other projects
        			$other_projects = DB::table('project AS p')
        			->join('project_description AS p_des',function($join){
        				$join->on('p.id','=','p_des.project_id');
        				$join->where('p_des.language_id','=',Session::get('applangId'));
        			})
        			->join('project_category AS cat','cat.id','=','p.project_category_id')
        			->join('project_category_description AS cat_des',function($join){
        				$join->on('cat.id','=','cat_des.project_category_id');
        				$join->where('cat_des.language_id','=',Session::get('applangId'));
        			})
        			->where('p.project_status',1)
        			->where('p.id','<>',$id)
        			->select('p.id','p.image','cat.id AS cat_id','cat_des.name AS cat_name',
        					'p.project_start','p_des.name','p_des.location')
        					->get();
        			
        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        return view("fo.project_detail")
        	->with('project',$project)
        	->with('other_project',$other_projects)
         	->with('slide_image',$collect_slide);
    }
    // project_progress
    public function project(){

        $menu_id=2;
        $collect_slide = $this->getSlideByMenu($menu_id);
        //project category
        $project_categories = DB::table('project_category AS cat')
        			->join('project_category_description AS cat_des',function($join){
        				$join->on('cat.id','=','cat_des.project_category_id');
        				$join->where('cat_des.language_id','=',Session::get('applangId'));
        			})
        			->where('cat.is_active',true)
        			->select('cat.id','cat_des.name')
        			->get();

        //	all project
        $projects = DB::table('project AS p')
        			->join('project_description AS p_des',function($join){
        				$join->on('p.id','=','p_des.project_id');
        				$join->where('p_des.language_id','=',Session::get('applangId'));
        			})
        			->join('project_category AS cat','cat.id','=','p.project_category_id')
        			->join('project_category_description AS cat_des',function($join){
        				$join->on('cat.id','=','cat_des.project_category_id');
        				$join->where('cat_des.language_id','=',Session::get('applangId'));
        			})
        			->where('p.project_status',1)
        			->select('p.id','p.image','cat.id AS cat_id','cat_des.name AS cat_name',
        					'p.project_start','p_des.name','p_des.location')
        			->get();
                    //dd($projects);
        return view("fo.project_progress")
        ->with('project_categories',$project_categories)
        ->with('projects',$projects)
        ->with('slide_image',$collect_slide);
    }
    // career
    public function career(){
    
        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        $careers = DB::table('career')
             ->join('career_description AS car_des',function($join){
            	$join->on('career.id','=','car_des.career_id');
            	$join->where('car_des.language_id','=',Session::get('applangId'));
            })
            ->select('career.*','car_des.job_title')
            ->where('career.is_active',true)
            ->get();
        return view("fo.career")
        ->with('slide_image',$collect_slide)
        ->with('careers',$careers);
    }
    // carrer_detail
    public function career_detail($id){
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $menu_id=1;
        $collect_slide = $this->getSlideByMenu($menu_id);
        $career_detail = DB::table('career')
            ->join('career_description AS car_des',function($join){
            	$join->on('career.id','=','car_des.career_id');
            	$join->where('car_des.language_id','=',Session::get('applangId'));
            })
            ->select('career.*','car_des.job_title','car_des.position_available',
            		'car_des.location','car_des.description')
            ->where('career.id',$id)
            ->first();
        return view("fo.career_detail")
        ->with('career_detail',$career_detail)
        ->with('slide_image',$collect_slide);
    }
    
    private function getSlideByMenu($menu_id){
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

    	$collect_slide = DB::table('slide_menu as sm')
    	->Join('slide_image as si','sm.slide_id','=','si.slide_id')
    	->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
    	->select('si.image as image','sid.description','sid.title')
    	->where('sm.fmenu_id',$menu_id)
    	->where('sid.language_id',Session::get('applangId'))
    	->get();
    	return $collect_slide;
    }

}
