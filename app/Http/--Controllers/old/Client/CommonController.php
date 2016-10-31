<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Language;
use App\Models\Admin\FlightType;
use App\Models\Admin\FlightNumber;
use App\Models\Admin\FlightTime;
use App\Models\Admin\FlightRoute;
use App\Models\Admin\FlightOrigin;
use App\Models\Admin\FlightDestination;
use App\Models\Admin\FlightDescription;
use DB;
use App\user;
use Mail;
use Validator;
use Auth;
use App;
use Session;
use Input;

class CommonController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Phnom_Penh');
        $languages = DB::table('language')->get();
        $language_id = Session::get('applangId');
        
        if($language_id==1){
          App::setLocale('kh');
        }else if($language_id==2){
          App::setLocale('en');
        }else if($language_id==3){
          App::setLocale('ch(simplify)');
        }else if($language_id==4){
          App::setLocale('ch(traditional)');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $testing = "test";
        $id = 1;
        $article_title = $this-> getTitleArticle($id, $language_id);
        //slide
        $slide = DB::table('slide as s')
                ->leftjoin('slide_description as sd','s.id','=','sd.slide_id')
                ->where('s.is_active',1)
                ->where('sd.language_id',$language_id)
                ->select('s.image as image','sd.title as title','sd.sub_title as sub_title','sd.description as description')
                ->get();

        //Quick Link
        $quick_link = DB::table('quicklink as ql')
                      ->leftjoin('quicklink_description as qld','ql.id','=','qld.quicklink_id')
                      ->where('ql.is_active',1)
                      ->where('qld.language_id',$language_id)
                      ->select('ql.thumbnail as thumbnail','ql.url as url','qld.title as title','qld.description as description')
                      ->get();

        //Discover
        $discover = DB::table('discover as d')
                    ->leftjoin('discover_description as dd','d.id','=','dd.discover_id')
                    ->where('d.is_active',1)
                    ->where('dd.language_id',$language_id)
                    ->select('d.image as image','dd.title as title','dd.description as description')
                    ->get();

        //Promotions
        $promotions = DB::table('promotions as p')
                ->leftjoin('promotions_description as pd','p.id','=','pd.promotions_id')
                ->where('p.is_active',1)
                ->where('pd.language_id',$language_id)
                ->select('p.image as image','pd.image as pd_image','pd.title as pd_title')
                ->get();

        //Welcome Page
        $welcome_home = DB::table('content as c')
                ->leftjoin('content_description as cd','c.id','=','cd.content_id')
                ->where('c.is_active',1)
                ->where('c.fmenu_id',1)
                ->where('cd.language_id',$language_id)
                ->select('cd.description as welcome_description')
                ->get();

        //dd($welcome_home);
        //dd($promotions);
        $flightRoute = FlightRoute::lists('name','id');
        //dd($discover);
        return view('Client.home')->with('languages',$languages)  
                                  ->with('article_title',$article_title)
                                  ->with('slide',$slide)
                                  ->with('discover',$discover)
                                  ->with('welcome_description',$welcome_home)
                                  ->with('promotions',$promotions)
                                  ->with('quick_link',$quick_link)
                                  ->with('flightRoute',$flightRoute)
                                  ->with('testing',$testing)
                                  ->with('default',$id)
                                  ->with('id',$id)
                                  ->with('widget',$widget)
                                  ->with('topMenu',$topMenu)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
    }

    //about
    public function about()
    {
        
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $id = 3;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.about')->with('languages',$languages)
                                   ->with('article_title',$article_title)
                                   ->with('id',$id)
                                   ->with('widget',$widget)
                                   ->with('topMenu',$topMenu)
                                   ->with('mainMenu',$mainMenu)
                                   ->with('footerMenu',$footerMenu);
    }

    //where we fly
    public function where_we_fly()
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $id = 11;
        $article_title = $this-> getTitleArticle($id, $language_id);
        //dd($widget);
        
        $data = DB::table('where_we_fly as wf')
                    ->leftjoin('where_we_fly_description as wfd','wf.id','=','wfd.where_we_fly_id')
                    ->where('wf.is_active',1)
                    ->where('wfd.language_id',$language_id)
                    ->select('wf.image as image','wfd.title as title','wfd.description as description')
                    ->get();

        //dd($data);

        return view('Client.where_we_fly')->with('languages',$languages)
                                  ->with('article_title',$article_title)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('widget',$widget)
                                  ->with('topMenu',$topMenu)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
    }

    //where we fly
    public function our_vision_mission()
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);

        $widget = $this->getWidget();
        $id = 2;
        $article_title = $this-> getTitleArticle($id, $language_id);
        //dd($widget);
        //vision_mission
        $vision_mission = DB::table('vision_mission as v')
                          ->leftjoin('vision_mission_description as vmd','v.id','=','vmd.vision_mission_id')
                          ->where('v.is_active',1)
                          ->where('vmd.language_id',$language_id)
                          ->select('v.image as image','vmd.title as title','vmd.description as description')
                          ->get();
        //dd($vision_mission);

        return view('Client.our_vision_mission')->with('languages',$languages)
                            ->with('article_title',$article_title)
                            ->with('id',$id)
                            ->with('vision_mission',$vision_mission)
                            ->with('widget',$widget)
                            ->with('topMenu',$topMenu)
                            ->with('mainMenu',$mainMenu)
                            ->with('footerMenu',$footerMenu);
    }

    //Career
    public function career()
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $id = 9;
        $article_title = $this-> getTitleArticle($id, $language_id);
        //career
        $career = DB::table('career as c')
                  ->leftjoin('career_description as cd','c.id','=','cd.career_id')
                  ->where('c.is_active',1)
                  ->where('cd.language_id',$language_id)
                  ->orderBy('c.id','DESC')
                  ->select('cd.*','c.updated_at as updated_at','c.created_at as created_at','c.image as image','c.id as cid','c.report_to as report_to','c.job_code as job_code','c.is_active as is_active')
                  ->get();
                  //dd($career);
        return view('Client.career')->with('languages',$languages)
                  ->with('article_title',$article_title)
                  ->with('widget',$widget)
                  ->with('career',$career)
                  ->with('topMenu',$topMenu)
                  ->with('mainMenu',$mainMenu)
                  ->with('footerMenu',$footerMenu);
    }

    //apply_form
    public function apply_form($id_job)
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $id = 9;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.apply_form')->with('languages',$languages)
                                        ->with('article_title',$article_title)
                                        ->with('widget',$widget)
                                        ->with('id_job',$id_job)
                                        ->with('topMenu',$topMenu)
                                        ->with('mainMenu',$mainMenu)
                                        ->with('footerMenu',$footerMenu);
    }

    //apply Career Form
    public function applyCareer(Request $request){
       
        $input = $request->all();
        $id_job = $input['id_job'];
        $job_title = DB::table('career_description')->where('career_id', $id_job)->where('language_id',CONFIG_LANGUAGE)->pluck('job_title');
        //dd($job_title);

        $name = $request->get('name');
        $email = $request->get('email');
        $contact = $request->get('contact');//CAREER_EMAIL;
        $address = $request->get('address');
      
        $pathToFile='';
        // checking file is valid.
        $size = (str_replace('MB','',MAX_FILE_SIZE))*1024;
        if (Input::file('attach_file')!='') {
           $rules = array(
	          'name' => 'Required',
	          'email' => 'Required|Between:3,64|Email',
	          'attach_file' => 'max:'.$size 
	        );
	         $messages = [
	           'name.required' => 'Provide your name!',
	           'email.required' => 'Please provide your email!',
	           'email.email' => 'Your email is invalid!', 
	           'attach_file.max' =>'Max attachment file size is '.MAX_FILE_SIZE.'!',      
	           ];
	  $v = Validator::make($input, $rules, $messages);
          if( $v->passes() ) {
	          $file_attach = $request->get('attach_file');
	          $date_create = date('d-M-Y/');
	          $destinationPath = 'images/uploads/career/attach_file/'.$date_create; // upload path
	          $extension = Input::file('attach_file')->getClientOriginalExtension(); // getting image extension
	          //$fileName = rand(11111,99999).'.'.$extension; // renameing image
	          $file_attach_name = Input::file('attach_file')->getClientOriginalName();
	
	          $file = preg_replace('/\s+/', '_', $file_attach_name);
	
	          Input::file('attach_file')->move($destinationPath, $file);
	          $pathToFile = SITE_HTTP_URL.'images/uploads/career/attach_file/'.$date_create.$file;
	  }else{
	  	return redirect('apply_form/'.$id_job)->withInput()->withErrors($v);
	  }
          //dd($pathToFile);
        }
          


        define('name', $name);
        define('attach_file', $pathToFile);
        define('job_title', $job_title);
        define('email', $email);
        define('contact', $contact);
        define('address', $address);
        //define('attach_file', $attach_file);



        //dd($subject);
         $rules = array(
          'name' => 'Required',
          'email' => 'Required|Between:3,64|Email',
        );

        $messages = [
           'name.required' => 'Provide your name!',
           'email.required' => 'Please provide your email!',
           'email.email' => 'Your email is invalid!',       ];

        $v = Validator::make($input, $rules, $messages);
        if( $v->passes() ) {
           // Mail::send('admin/report/mailscheduledreport', array('filename' => $filename), function($message) use ($csvPath, $email)
    
           //     $message->from('info@abc.com', 'Reports');
           //     $message->to($email)->subject('Reports');                
           //     $message->attach($csvPath);
           // });

        $data = $request->only(job_title,name, email, contact, address, attach_file);
         if (Input::file('attach_file')!='') {
            Mail::send('Client.emails.career', $data, function($message){
              $message->from(email, name);
              $message->to(CAREER_EMAIL)->subject(job_title);
              $message->attach(attach_file);
            });
          }else{
            Mail::send('Client.emails.career', $data, function($message){
                $message->from(email, name);
                $message->to(CAREER_EMAIL)->subject(job_title);
            });
          }
          return redirect('apply_form/'.$id_job)->with('message','Message has been sent! Thanks!');

        } else { 
          return redirect('apply_form/'.$id_job)->withInput()->withErrors($v);
        }

    }


    public function partnerus()
    {

      $language_id = Session::get('applangId');
      if(!$language_id) $language_id = CONFIG_LANGUAGE;
      //dd($language_id);
      $languages = Language::all();
      $topMenu = $this->getFMenuLists($language_id,1,0);
      $mainMenu = $this->getFMenuLists($language_id,2,0);
      $footerMenu = $this->getFMenuLists($language_id,3,0);
      $widget = $this->getWidget();
      $id = 7;
      $article_title = $this-> getTitleArticle($id, $language_id);

      return view('Client.partnerus')->with('languages',$languages)
                            ->with('article_title',$article_title)
                            ->with('id',$id)
                            ->with('widget',$widget)
                            ->with('topMenu',$topMenu)
                            ->with('mainMenu',$mainMenu)
                            ->with('footerMenu',$footerMenu);
 
    }

    //public send message
    public function sendToPartner(Request $request){
        $input = $request->all();
        $subject = $request->get('subject');
        $email = $request->get('email');
        $message = $request->get('message');
        //dd($email);
        define('email_visitor', $email);
        define('subject', $subject);
        define('message', $message);

        $message = $request->get('message');
        //dd($subject);
        $rules = array(
          'email' => 'Required|Between:3,64|Email',
          'subject'     => 'Required',
          'message'     => 'Required'
        );
        
        $messages = [
           'email.required' => 'Please provide your email!',
           'email.email' => 'Your email is invalid!',
           'subject.required' => 'Please provide subject!',
           'message.required' => 'Please provide messages!'
        ];

        $v = Validator::make($input, $rules, $messages);
        if( $v->passes() ) {
          
          $data = $request->only(email_visitor, subject, message);

          Mail::send('Client.emails.partner_us', $data, function($message){
              $message->from(email_visitor, "Visitor");
              $message->to(PARTNER_US_EMAIL)->subject(subject);
          });
          return redirect('partnerus')->with('message','Message has been sent! Thanks!');

        } else { 
          return redirect('partnerus')->withInput()->withErrors($v);
        }
    }


    //Team & Condistion
    public function TermCondition()
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
         $id = 7;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.term_condition')->with('languages',$languages)
                                  ->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
    
    }

     //Dangerous good
    public function DgCondition()
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
         $id = 7;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.dg')->with('languages',$languages)
                                  ->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
    
    }


    //Promotion 
    public function Promotion(){
       $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $widget = $this->getWidget();
        $id = 5;
        $article_title = $this-> getTitleArticle($id, $language_id);

        //promotions
        $promotions = DB::table('promotions as p')
                ->leftjoin('promotions_description as pd','p.id','=','pd.promotions_id')
                ->where('p.is_active',1)
                ->where('pd.language_id',$language_id)
                ->select('p.image as image','pd.title as title','pd.description as description')
                ->get();
              //dd($promotions);
        return view('Client.promotion')->with('languages',$languages)
                                        ->with('article_title',$article_title)
                                        ->with('id',$id)
                                        ->with('promotions',$promotions)
                                        ->with('widget',$widget)
                                        ->with('topMenu',$topMenu)
                                        ->with('mainMenu',$mainMenu)
                                        ->with('footerMenu',$footerMenu);
    }

    
    //Contact 
    public function Contact(){
        // return view('Client.emails.contact');
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);

        $widget = $this->getWidget();
        $id = 10;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.contact')->with('languages',$languages)
                                      ->with('article_title',$article_title)
                                      ->with('widget',$widget)
                                      ->with('topMenu',$topMenu)
                                      ->with('mainMenu',$mainMenu)
                                      ->with('footerMenu',$footerMenu);
    }

    //public send message
    public function sendToContactInfo(Request $request){
        $input = $request->all();
        $subject = $request->get('subject');
        $email = $request->get('email');
        $message = $request->get('message');
        //dd($email);
        define('email_visitor', $email);
        define('subject', $subject);
        define('message', $message);

        $message = $request->get('message');
        //dd($subject);
        $rules = array(
          'email' => 'Required|Between:3,64|Email',
          'subject'     => 'Required',
          'message'     => 'Required'
        );
        
        $messages = [
           'email.required' => 'Please provide your email!',
           'email.email' => 'Your email is invalid!',
           'subject.required' => 'Please provide subject!',
           'message.required' => 'Please provide messages!'
        ];

        $v = Validator::make($input, $rules, $messages);
        if( $v->passes() ) {

          $data = $request->only("email", "subject", "message");

          Mail::send('Client.emails.contact', $data, function($message){
              $message->from(email_visitor, "Visitor");
              $message->to(CONTACT_EMAIL)->subject(subject);
          });
          return redirect('contact')->with('message','Message has been sent! Thanks!');

        } else { 
          return redirect('contact')->withInput()->withErrors($v);
        }
    }

    //page
    public function page($id)
    {
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $data = $this->getContent($id, $language_id);
        //$data = DB::table('content_description')->where('content_id',$id)->first();
        //dd($data);
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.content')->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('footerMenu',$footerMenu);
    }
    //manage_booking
    public function manage_booking()
    {
        $id = 4;
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $data = $this->getContent($id, $language_id);
        //$data = DB::table('content_description')->where('content_id',$id)->first();
        //dd($data);
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.content')->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('footerMenu',$footerMenu);
    }

    //our route

    public function our_route()
    {
        $id = 12;
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $data = $this->getContent($id, $language_id);
        //$data = DB::table('content_description')->where('content_id',$id)->first();
        //dd($data);
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.content')->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('footerMenu',$footerMenu);
    }

    //About Us
    public function aboutus()
    {
        $id = 15;
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $data = $this->getContent($id, $language_id);
        //$data = DB::table('content_description')->where('content_id',$id)->first();
        //dd($data);
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.content')->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('footerMenu',$footerMenu);
    }
    
    //Our Valudes
    public function our_valudes()
    {
        $id = 20;
        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;

        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);
        $data = $this->getContent($id, $language_id);
        //$data = DB::table('content_description')->where('content_id',$id)->first();
        //dd($data);
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.content')->with('topMenu',$topMenu)
                                  ->with('article_title',$article_title)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('id',$id)
                                  ->with('data',$data)
                                  ->with('footerMenu',$footerMenu);
    }

    //Flight Info
    public function flight_info(Request $request)
    {
        $input = $request->all();
        $flight_type_id = $input['flight_type_id'];
        $flight_date = $input['flight_date'];
        $originalDate = $flight_date;
        $newDate = date("Y-m-d", strtotime($originalDate));
       // dd($newDate);
        $flight_number = $input['flight_number'];
        $flight_route = $input['route'];

        $flightRoute = DB::table('flight_route')->get();

        //FlightRoute::lists('name','id');

        $query = DB::table('flight_description as fd')
                              ->join('flight_type as f_type','fd.flight_type_id','=','f_type.id')
                              ->join('flight_number as fn','fd.flight_number_id','=','fn.id')
                              ->join('flight_time as ft','fd.flight_time_id','=','ft.id')
                              //->join('flight_origin as fo','fd.origin_id','=','fo.id')
                              ->join('flight_route as fr','fd.flight_route_id','=','fr.id')
                              //->join('flight_destination as fdes','fd.destination_id','=','fdes.id')
                              ->where('fd.is_active',1)
                              //->select('fd.*','fr.name as fr_name','f_type.name as type_name','fn.name as number_name','ft.time as ft_time','fo.name as origin_name','fdes.name as destination_name','fd.remark as remark');
                              ->select('fd.*','fr.name as fr_name','f_type.name as type_name','fn.name as number_name','ft.time as ft_time','fd.remark as remark','fd.flight_date as fdate');
                              //->get();
        //dd($query);
        if($request->has('flight_type_id'))
          $query->where('f_type.id',$flight_type_id);
        if($request->has('flight_number'))
          $query->where ('fn.name','Like','%'.$flight_number.'%');
        if($request->has('route'))
          $query->where ('fr.id','Like','%'.$flight_route.'%');
        if($request->has('flight_date'))
          $query->where ('fd.flight_date','Like','%'.$newDate.'%');
        
        $data = $query->get();
        //dd($flightDescription);

        $language_id = Session::get('applangId');
        if(!$language_id) $language_id = CONFIG_LANGUAGE;
        //dd($language_id);
        $languages = Language::all();
        $topMenu = $this->getFMenuLists($language_id,1,0);
        $mainMenu = $this->getFMenuLists($language_id,2,0);
        $footerMenu = $this->getFMenuLists($language_id,3,0);

        $widget = $this->getWidget();
        $id = 1;
        $article_title = $this-> getTitleArticle($id, $language_id);
        return view('Client.flight_info')->with('languages',$languages)
                                      ->with('article_title',$article_title)
                                      ->with('flight_type',$flight_type_id)
                                      ->with('data',$data)
                                      ->with('flightRoute',$flightRoute)
                                      ->with('flight_route_id',$flight_route)
                                      ->with('flight_number',$flight_number)
                                      ->with('flight_date',$originalDate)
                                      ->with('widget',$widget)
                                      ->with('topMenu',$topMenu)
                                      ->with('mainMenu',$mainMenu)
                                      ->with('footerMenu',$footerMenu);
    }


}   
