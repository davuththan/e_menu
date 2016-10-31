<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Config\Language;
use Input;
use Carbon\Carbon;
use DB;
use Session;

class CandidateController extends Controller
{
    private $title = "Candidate";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('menuCode', $this->getMenu());
        $data = DB::table('candidate')->paginate(ITEM_PER_PAGE);
        return view('bo.candidate.list',compact('data'))
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
        //
        $languages = Language::where('is_active',true)->get();
        return view('bo.candidate.detail')
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
        $data = $request->all();
        // save Candidate
        $candidate = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'contact' => $data['contact'],
                'attach_file' => $data['attach_file'],
                'address' => $data['address'],
                'remark' => $data['remark'],
            );
        $candidate = Candidate::create($candidate);
        $this->activityLog("create");
        return redirect('admin/cmgr/candidate')
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
        //
        $entity = Candidate::find($id);
         return  view('bo.candidate.detail',compact('entity'))
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
        //
        $data = $request->all();
        $oldCandidate = Candidate::find($id);
        //update Candidate
        $candidate = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'contact' => $request->input('contact'),
                'attach_file' => $request->input('attach_file'),
                'address' => $request->input('address'),
                'remark' => $request->input('remark'),
                //'is_active' =>true
        );
        
        $oldCandidate->update($candidate);
        $this->activityLog("update");
        return redirect('admin/cmgr/candidate')
                    ->with('message','Updated Successfully');
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
        $candidate = Candidate::find($id)->delete();
        return redirect()->back()->with('message','Delete Successfully');
    }
}
