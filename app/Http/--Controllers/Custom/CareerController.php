<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerDes;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use Session;

class CareerController extends Controller
{
	private $title = "Career";
	public function __construct(){
		//$this->middleware('validator:App\Models\Career',['only' => ['store','update']]);
		//$this->middleware('auth');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
        Session::set('menuCode', $this->getMenu());
    	$data = Career::where('is_active',true)->paginate(ITEM_PER_PAGE);
    	return view('bo.career.list',compact('data'))
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
    	return view('bo.career.detail')
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
    	$date_posting_date = $data['posting_date'];
        $posting_date = date("Y-m-d", strtotime($date_posting_date));
        $data_closing_date = $data['closing_date'];
        $closing_date = date("Y-m-d", strtotime($data_closing_date));
    	$destinationPath = "images/upload/career/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}
    	//save career
        $career = array(
        		'image' => $fileName,
        		'report_to' => $data['report_to'],
        		'job_code' => $data['job_code'],
                'posting_date' => $posting_date,
                'closing_date' => $closing_date,
        		'is_active' =>true
        );
        $career = Career::create($career);
        //save career description
        foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
        	$career_des = array(
        		'career_id' => 	$career->id,
        		'language_id' => $language_id,
        		'job_title' => $data['job_title'][$language_id],
        		'position_available' => $data['position_available'][$language_id],
        		'location' => $data['location'][$language_id],
        		'description' => $data['description'][$language_id],
        		'meta_description' => $data['meta_description'][$language_id],
        		'meta_keywords' => $data['meta_keywords'][$language_id],
        	);
        	CareerDes::create($career_des);
        }
        $this->activityLog("create");
        return redirect('admin/cmgr/career')
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
        $entity = Career::find($id);
        $career_des = $entity->career_des;
        $languages = Language::where('is_active',true)->get();
        return  view('bo.career.detail',compact('entity'))
        		->with('career_des',$career_des)
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
        $date_posting_date = $data['posting_date'];
        $posting_date = date("Y-m-d", strtotime($date_posting_date));
        $data_closing_date = $data['closing_date'];
        $closing_date = date("Y-m-d", strtotime($data_closing_date));
    	$oldCareer = Career::find($id);
    	$destinationPath = "images/upload/career/";
    	$fileName = "";
    	//upload image
    	if($request->hasFile('image')){
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileName = $destinationPath.'image_'.Carbon::now()->format('d_M_Y_h_i_s').".".$extension;
    		$request->file('image')->move($destinationPath,$fileName);
    	}else{
    		$fileName = $oldCareer->image;
    	}
    	//update career
    	$career = array(
    			'image' => $fileName,
    			'report_to' => $request->input('report_to'),
    			'job_code' => $request->input('job_code'),
                'posting_date' => $posting_date,
                'closing_date' => $closing_date,
    			//'is_active' =>true
    	);
    	
    	$oldCareer->update($career);
    	foreach($oldCareer->career_des as $career_des){
    		$career_des->delete();
    	}
    	//update career description
    	foreach ($data['meta_keywords'] as $language_id => $meta_keywords){
    		$career_des = array(
    				'career_id' => 	$oldCareer->id,
    				'language_id' => $language_id,
    				'job_title' => $data['job_title'][$language_id],
    				'position_available' => $data['position_available'][$language_id],
    				'location' => $data['location'][$language_id],
    				'description' => $data['description'][$language_id],
    				'meta_description' => $data['meta_description'][$language_id],
    				'meta_keywords' => $data['meta_keywords'][$language_id],
    		);
    		CareerDes::create($career_des);
    	}
    	$this->activityLog("update");
    	return redirect('admin/cmgr/career')
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
    	
       $career = Career::find($id);
       $career->update(['is_active'=>false]);
       return redirect()->back()->with('message','Remove Successfully');
    }
    
}
