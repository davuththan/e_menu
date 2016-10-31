<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use DB;
use Session;
class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */

	protected $auth;
	public $emp_id;
	/**
	* Create a new filter instance.
	*
	* @param  Guard  $auth
	* @return void
	*/

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		//$emp_id = Auth::user()->emp_id;
		//Session::flash('permissionByMenuID',$emp_id);
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
		
		// $permission_session = Session::get('permissionOn_Menu_ID');
		// //Set permission for Each Route
		// $request_uri= $_SERVER['REQUEST_URI'];
		// $group_id = Auth::user()->group_id;
		// $menu = DB::table('group_role')
		// 		->join('group_role_detail', 'group_role_detail.group_role_id', '=', 'group_role.id')
		// 		->join('menu', 'menu.menu_code', '=', 'group_role_detail.menu_code')
		// 		->where('group_role.id','=',$group_id)
		// 		->where('menu.parent_id','>',0)
		// 		->select('group_role_detail.*','group_role.id as grouRole_id','group_role_detail.read as groupRead','group_role_detail.write as groupWrite','menu.icon as menuIcon','menu.url as menuUrl','menu.menu_name as menuname', 'group_role_detail.menu_code as groupMenuCode','group_role_detail.menu_id as groupMenu_id')
		// 		->get();

		// $menu = DB::table('group_role_detail')
		// 		->where('group_role_id','=',1)
		// 		->get();

		// $results_menu = DB::table('group_role_detail')
		  //                   //->where('group_role_id', '=', 1)
		  //                    ->get();

		  //      	$menu_codeID = '';
		// foreach ($results_menu as $key => $value) {
		// 	$menu_codeID .= $value->menu_code."<br/>";
		// }

		// echo $menu_codeID;
		//echo count($menu_codeID);
		
		//$menu_id='';
		//$menu_code_arr = explode(':',$menu_codeID);
		//print_r($menu_code_arr);
		//$read = DB::table('menu')->where('url','=', $request_uri)->pluck('id');

		// if($permission_session!=""){
		// 	if(!in_array($permission_session, $menu_code_arr)){
		// 		return view('admin.common.permissionControl');
		// 	}else{
		// 		$read = DB::table('group_role_detail')->where('menu_code','=', $permission_session)->pluck('read');
		// 		$write = DB::table('group_role_detail')->where('menu_code','=', $permission_session)->pluck('write');
		// 		if($read==1 && $write==1){
		// 			return $next($request);
		// 		}else if($read==0){
		// 			return view('admin.common.permissionControl');						
		// 			//return $next($request);
		// 		}else{
		// 			$smenu_code = DB::table('menu')->where('url','=', $request_uri)->pluck('menu_code');
		// 			if($smenu_code!=""){
		// 				return $next($request);	
		// 			}else{
		// 				return view('admin.common.permissionControl');
		// 			}
		// 		}
		// 	}
		// }//else{
			//return view('admin.common.permissionControl');
		//}
		return $next($request);	
	}

}
