<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class FoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
       
        return view('fo.index')
                ->with('slide_image',$collect_slide);
    }
    // Service
    public function service(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view('fo.service')
             ->with('slide_image',$collect_slide);
    }
    // About
    public function about(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view('fo.about')
        ->with('slide_image',$collect_slide);
    }
    // Contact
    public function contact(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view('fo.contact')
        ->with('slide_image',$collect_slide);
    }
    // Event and New
    public function event_news(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view("fo.event_news")
        ->with('slide_image',$collect_slide);
    }
    // gallery
    public function gallery(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view("fo.gallery")
        ->with('slide_image',$collect_slide);
    }
    //project_detail
    public function project_detail(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            ->get();
        return view("fo.project_detail")
         ->with('slide_image',$collect_slide);
    }
    // project_progress
    public function project_progress(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            ->get();
        //dd($collect_slide);
        return view("fo.project_progress")
        ->with('slide_image',$collect_slide);
    }
    // career
    public function carrer(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view("fo.carrer")
        ->with('slide_image',$collect_slide);
    }
    // carrer_detail
    public function carrer_detail(){
        $menu_id=1;
        $language_id=2;
        $collect_slide = DB::table('slide_menu as sm')
                            ->Join('slide_image as si','sm.slide_id','=','si.slide_id')
                            ->Join('slide_image_description as sid','si.id','=','sid.slide_image_id')
                            ->select('si.image as image','sid.description','sid.title')
                            ->where('sm.fmenu_id',$menu_id)
                            ->where('sid.language_id',$language_id)
                            //->toSql();
                            ->get();
        //dd($collect_slide);
        return view("fo.carrer_detail")
        ->with('slide_image',$collect_slide);
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }
}
