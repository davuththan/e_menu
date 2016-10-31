<?php 

namespace App\Http\Middleware;

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
		date_default_timezone_set('Asia/Phnom_Penh');
			
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

		
		$permission_session = Session::get('permissionOn_Menu_ID');
		//Set permission for Each Route
		$request_uri= $_SERVER['REQUEST_URI'];
		$group_id = Auth::user()->group_id;
		$emp_id = Auth::user()->emp_id;
		$status_group = DB::table('group_user')->where('id', $group_id)->pluck('status');
		$group_role_id = DB::table('group_role')->where('group_id', $group_id)->pluck('id');
		
		$results_menu = DB::table('group_role')
				->join('group_role_detail', 'group_role_detail.group_role_id', '=', 'group_role.id')
				->join('menu', 'menu.menu_code', '=', 'group_role_detail.menu_code')
				->where('group_role.group_id','=',$group_id)
				->where('menu.parent_id','>',0)
				->select('group_role_detail.*','group_role.id as grouRole_id','group_role_detail.read as groupRead','group_role_detail.write as groupWrite','menu.icon as menuIcon','menu.url as menuUrl','menu.menu_name as menuname', 'group_role_detail.menu_code as groupMenuCode','group_role_detail.menu_id as groupMenu_id')
				->get();

       	$menu_codeID = '';
		foreach ($results_menu as $key => $value) {
			$menu_codeID .= $value->menu_code.":";
		}

		$menu_id='';
		$menu_code_arr = explode(':',$menu_codeID);
		
		if($permission_session!=''){
			if(!in_array($permission_session, $menu_code_arr)){
				// return view('fo.common.permissionControl');
			}else{
				$read = DB::table('group_role_detail')->where('menu_code','=', $permission_session)->where('group_role_id','=',$group_role_id)->pluck('read');
				$write = DB::table('group_role_detail')->where('menu_code','=', $permission_session)->where('group_role_id','=',$group_role_id)->pluck('write');
				if($read==1 && $write==1){
					return $next($request);

				}else if($read==0){
					// return view('fo.common.permissionControl');
				}else{
					$smenu_code = DB::table('menu')->where('url','=', $request_uri)->pluck('menu_code');
					if($smenu_code!=""){
						return $next($request);	
					}else{
						// return view('fo.common.permissionControl');
					}
				}
			}
		}
		
		return $next($request);	
	}

}
