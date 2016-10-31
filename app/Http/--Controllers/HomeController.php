<?php namespace App\Http\Controllers;

use DB;
//use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
		$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = DB::table('users')->get();
        return view('common.home', ['users' => $users]);
		//$users = DB::table('users')->get();
        //return View::make('common.home', compact('users'));
		//return view('common/home');
	}

	public function contact()
	{
		return view('common.contact');
	}

}
