<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Language;

use DB;
use App\user;
use Validator;
use Auth;
use Session;

class ContentController extends Controller
{

    public function __construct()
    {
        //echo $user_role = Auth::user()->role_id;
        //$this->middleware('auth');
        
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
        //dd($widget);
        return view('Client.home')->with('languages',$languages)
                                  ->with('widget',$widget)
                                  ->with('topMenu',$topMenu)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
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
        
        return view('Client.term_condition')->with('languages',$languages)
                                  ->with('topMenu',$topMenu)
                                  ->with('mainMenu',$mainMenu)
                                  ->with('footerMenu',$footerMenu);
    }

}   
