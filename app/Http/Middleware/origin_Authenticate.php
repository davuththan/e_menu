<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use DB;
class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */

	protected $auth;
	
	/**
	* Create a new filter instance.
	*
	* @param  Guard  $auth
	* @return void
	*/

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

	public function handle($request, Closure $next)
	{	
		 //auth -> guest
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}

		//Set permission for Each Route
        $request_uri= $_SERVER['REQUEST_URI'];
        $group_id = Auth::user()->group_id;
		$status_group = DB::table('group_user')->where('id', $group_id)->pluck('status');
        if(isset(Auth::user()->group_id)){
			//group Role ID
	        $group_id = Auth::user()->group_id;
	        //select from group role
	        $role_group_id = DB::table('group_role')->where('group_id', $group_id)->pluck('id');  
	        //select from group role detail
	        $group_role_detail = DB::table('group_role_detail')
	                     		->where('group_role_id', intval($role_group_id))->get();
	 		$global_menu_id = "";
	 		$sub_menuCode_group_arrayd="";
	        foreach ($group_role_detail as $group_role_details) {
	        	$sub_menuCode_group = $group_role_details->menu_code;
	        	//$sub_menuCode_group_array .= $group_role_details->sub_menu_code.":";
	        	$m_smenu_code = DB::table('menu')->where('menu_code', $sub_menuCode_group)->pluck('url');

	        	//$global_menu_id .= $sub_menuCode_group;
	        	if((strpos($request_uri,$m_smenu_code)!==false)){
		     		$global_menu_id .= $sub_menuCode_group;
		     		$sub_menuCode_group_arrayd .= $group_role_details->menu_code;
		     	}
	        }
	         //Select Menu
	         $slc_menuAll = DB::table('menu')->get();
	         $all_menu="";
	         foreach ($slc_menuAll as $key => $value) {
	        	$all_menu .= $value->menu_code.",";
	         }
	        //Explode Permission Menu
	        $permission_data = explode(',',$all_menu);
	       	//print_r($permission_data);
	        if(in_array($global_menu_id, $permission_data)){
	            if($global_menu_id==""){
	            	//staus Group=2 if they are cashier
					if($status_group==2){
						return redirect('/cashier/welcome');
					}else{
						//return view('admin.common.permissionControl');
						return $next($request);
					}
	            }
	        }
	     }
	     //staus Group=2 if they are cashier
		if($status_group==2){
			return redirect('/cashier/welcome');
		}else{
			return $next($request);
		}
	}

}
