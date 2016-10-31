<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\BusinessType;
use App\Models\Admin\Position;
use App\Models\Admin\BaseCountry;
use App\Models\Admin\MemberType;
use App\Models\Admin\Member;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class MemberController extends Controller
{
	
	public $view_title = "Members <small> >> Member</small>";

    public function __construct()
    {

    }
    
    public function index()
    {	
        $members = Member::all();
        return view('Admin.members.member.index')
                ->with('members',$members)
                ->with('view_title',$this->view_title);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$business_type = BusinessType::lists('name','id');
    	$member_type = MemberType::lists('name','id');
        $base_country = BaseCountry::lists('name','id');
    	$position = Position::lists('name','id');

        return view('Admin.members.member.form')
					->with('business_type',$business_type)
					->with('member_type',$member_type)
					->with('position',$position)
                    ->with('base_country',$base_country)
					->with('view_title',$this->view_title)
					->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(MemberRequest $request)
    {
        $input = $request->all();
       
        if(Input::file('image')!=''){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/upload/members/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            //$fileName = rand(11111,99999).'.'.$extension; // renameing image
            $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading 

            DB::table('member')->insert(
                [
                    'name' => $input['name'],
                    'image' => $date_create.$fileName,
                    'member_type_id' => $input['member_type_id'],
                    'description' => $input['address'],
                    'business_type_id' => $input['business_type_id'],
                    'position_id' => $input['position_id'],
                    'company_representative' => $input['company_representative'],
                    // 'base_country' => $input['base_country'],
                    'base_country_id' => $input['base_country_id'],
                    'website' => $input['website'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'email' => $input['email'],
                    'remark' => $input['remark'],
                    'modified_by' => $input['modified_by'],
                ]
            );
        }else{

            DB::table('member')->insert(
                [
                    'name' => $input['name'],
                    'member_type_id' => $input['member_type_id'],
                    'business_type_id' => $input['business_type_id'],
                    'description' => $input['address'],
                    'position_id' => $input['position_id'],
                    'company_representative' => $input['company_representative'],
                    'base_country_id' => $input['base_country_id'],
                    'website' => $input['website'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'email' => $input['email'],
                    'remark' => $input['remark'],
                    'modified_by' => $input['modified_by'],
                ]
            );
        }

        // Member::create($request->all());
        return redirect("admin/members/member")->with('message',"Member => (".$input['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business_type = BusinessType::lists('name','id');
        $member_type = MemberType::lists('name','id');
        $base_country = BaseCountry::lists('name','id');
        $position = Position::lists('name','id');

        $Members = Member::find($id);
        return view('Admin.members.member.form')->with('Members',$Members)
                                        ->with('view_title',$this->view_title)
                                        ->with('business_type',$business_type)
                                        ->with('member_type',$member_type)
                                        ->with('base_country',$base_country)
                                        ->with('position',$position)
                                        ->with('action',"View");
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business_type = BusinessType::lists('name','id');
        $member_type = MemberType::lists('name','id');
        $base_country = BaseCountry::lists('name','id');
        $position = Position::lists('name','id');

        $Members = Member::find($id);
        return view('Admin.members.member.form')->with('Members',$Members)
                                        ->with('view_title',$this->view_title)
                                        ->with('business_type',$business_type)
                                        ->with('base_country',$base_country)
                                        ->with('member_type',$member_type)
                                        ->with('position',$position)
                                        ->with('action',"Edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $id)
    {
       $input = $request->all();

        if(Input::file('image')!=''){
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/upload/members/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            //$fileName = rand(11111,99999).'.'.$extension; // renameing image
            $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading 

            DB::table('member')
            ->where('id',$id)
            ->update([
                'name' => $input['name'],
                'image' => $date_create.$fileName,
                'member_type_id' => $input['member_type_id'],
                'description' => $input['address'],
                'business_type_id' => $input['business_type_id'],
                'position_id' => $input['position_id'],
                'company_representative' => $input['company_representative'],
                'base_country_id' => $input['base_country_id'],
                'website' => $input['website'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'email' => $input['email'],
                'remark' => $input['remark'],
                'modified_by' => $input['modified_by'],
            ]);

        }else{
            DB::table('member')
                ->where('id',$id)
                ->update([
                    'name' => $input['name'],
                    'member_type_id' => $input['member_type_id'],
                    'description' => $input['address'],
                    'business_type_id' => $input['business_type_id'],
                    'position_id' => $input['position_id'],
                    'company_representative' => $input['company_representative'],
                    'base_country_id' => $input['base_country_id'],
                    'website' => $input['website'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'email' => $input['email'],
                    'remark' => $input['remark'],
                    'modified_by' => $input['modified_by'],
                ]);
        }

       // $Member = Member::find($id);
       // $Member->update($request->all());
       return redirect("admin/members/member")->with('message',"Member => (".$input['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Member::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}

