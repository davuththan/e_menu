<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Drawer;
use App\Models\Admin\Employee;
use App\Models\Admin\CityLedger;
use App\Models\Admin\ActivityLog;
use DB;
use App\user;
use Validator;
use Auth;
use Session;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //Assign All Menu Code For Permission
        $menu_code = 's24';
        Session::flash('permissionOn_Menu_ID',$menu_code);

    }

    public function index()
    {
        //Drawer
        //$drawer = Drawer::all();
       // $total_drawer = $drawer->count();
        //User
        $user = user::all();
        $total_user = $user->count();
        //Total Sales
        //$sales_dollar = CityLedger::all();

        //########Activity LogList
        $ActivityLog = DB::table('activity_log')
                       ->join('user','user.id','=','activity_log.user_id')
                       ->select('activity_log.*','user.username as username','user.photo as photo')
                       ->limit(10)
                       ->OrderBy('id','DESC')
                       ->get();

        return view('Admin.common.home')
                ->with('ActivityLog',$ActivityLog)
               // ->with('total_drawer',$total_drawer)
                ->with('total_user',$total_user)
               // ->with('sales_dollar',$sales_dollar)
			   ;
    }

    //Activity Log
    public function activity_log()
    {
        //$ActivityLog = ActivityLog::limit('name','id');
        $ActivityLog = DB::table('activity_log')
                       // ->join('menu','menu.menu_code','=','activity_log.menu_code')
                       ->join('user','user.id','=','activity_log.user_id')
                       //->select('activity_log.*','menu.menu_name as menuName','user.username as username')
                       ->select('activity_log.*','user.username as username')
                       ->OrderBy('id','DESC')
                       ->get();

        return view('Admin.activityLog.index')
                ->with('ActivityLog',$ActivityLog);
    }

    //Calendar
    public function calendar()
    {
        return view('Admin.common.calendar');
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
