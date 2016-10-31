<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsefulInfoListingRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\UsefulInfoListing;
use App\Models\Admin\UsefulInfoCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class UsefulInfoListingController extends Controller
{
	
	public $view_title = "Useful Information <small> >> Useful Info Listing</small>";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $useful_listings = UsefulInfoListing::OrderBy('year','DESC')->get();
        return view('Admin.useful_information.useful_listing.index')
                ->with('useful_listings',$useful_listings)
                ->with('view_title',$this->view_title);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $useful_info_category = UsefulInfoCategory::lists('name','id');
        return view('Admin.useful_information.useful_listing.form')
        								->with('view_title',$this->view_title)
                                        ->with('useful_info_category',$useful_info_category)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UsefulInfoListingRequest $request)
    {
        $input = $request->all();
        $pathToFile='';
        // checking file is valid.
        // dd(Input::file('attach_file'));
        $date_create = date('d-M-Y/');
        $size = (str_replace('MB','',MAX_FILE_SIZE))*1024;
        if (Input::file('attach_file')!='') {
            $rules = array(
              'name' => 'Required',
              'attach_file' => 'max:'.$size 
            );
            $messages = [
               'name.required' => 'Provide your name!',
               'attach_file.max' =>'Max attachment file size is '.MAX_FILE_SIZE.'!',      
            ];

            $v = Validator::make($input, $rules, $messages);
            if( $v->passes() ) {
              $file_attach = $request->get('attach_file');
              $destinationPath = 'images/upload/useful_information/attach_file/'.$date_create; 
              $extension = Input::file('attach_file')->getClientOriginalExtension();
              // upload
              $file_attach_name = Input::file('attach_file')->getClientOriginalName();

              $file = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name);

              Input::file('attach_file')->move($destinationPath, $file);
            
              $pathToFile = SITE_HTTP_URL.'images/upload/useful_information/attach_file/'.$date_create.$file;

              $UsefulInfoListing= UsefulInfoListing::create([
                'name' => $input['name'],
                'useful_InfoCategory_id' => $input['useful_InfoCategory_id'],
                'url' => $input['url'],
                'year' => $input['year'],
                'modified_by' => Auth::user()->id,
                'attach_file' => $date_create.$file,
                'description' => $input['description']
              ]);

              $LastId = $UsefulInfoListing->id;

            if(isset($input['attribute_data'])){
              $attributes_data = $input['attribute_data'];
              foreach ($attributes_data as $attribute_data) {
                $file_attachs = $attribute_data['attach_file'];
                $destinationPath_data = 'images/upload/useful_information/attach_file/'.$date_create; 
                $extension = $file_attachs->getClientOriginalExtension(); 
                $file_attach_name_data = $file_attachs->getClientOriginalName();
                
                $file_data = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name_data);
                // $file_data = preg_replace('/\s+/', '_', $file_attach_name_data);

                $file_attachs->move($destinationPath_data, $file_data);
                
                DB::table('useful_data')
                  ->insert(
                  [
                  'useful_description_id' => $LastId,
                  'name' => $attribute_data['name'],
                  'attach_file' => $date_create.$file_data,
                  ]
                );
              }
            }

          }else{
            return redirect()->back()->withErrors($v->errors());
          }

        }else{

          $UsefulInfoListing= UsefulInfoListing::create([
            'name' => $input['name'],
            'year' => $input['year'],
            'useful_InfoCategory_id' => $input['useful_InfoCategory_id'],
            'url' => $input['url'],
            'description' => $input['description']
          ]);

          $LastId = $UsefulInfoListing->id;

          if(isset($input['attribute_data'])){

            $attributes_data = $input['attribute_data'];

            foreach ($attributes_data as $attribute_data) {
              $file_attachs = $attribute_data['attach_file'];
              $destinationPath_data = 'images/upload/useful_information/attach_file/'.$date_create; 
              $extension = $file_attachs->getClientOriginalExtension(); 
              $file_attach_name_data = $file_attachs->getClientOriginalName();
              $file_data = preg_replace('/\s+/', '_', $file_attach_name_data);

              $file_attachs->move($destinationPath_data, $file_data);
              
              DB::table('useful_data')
                ->insert(
                [
                'useful_description_id' => $LastId,
                'name' => $attribute_data['name'],
                'attach_file' => $date_create.$file_data,
                ]
              );
            }

          }
        }

      return redirect("admin/useful_information/useful_listing")->with('message',"Useful Information => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $UsefulInfoListings = UsefulInfoListing::find($id);
        $useful_info_category = UsefulInfoCategory::lists('name','id');
        return view('Admin.useful_information.useful_listing.form')
                                        ->with('UsefulInfoListings',$UsefulInfoListings)
                                        ->with('useful_info_category',$useful_info_category)
                                        ->with('view_title',$this->view_title)
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
      
      $UsefulInfoListings = UsefulInfoListing::find($id);
      $useful_info_category = UsefulInfoCategory::lists('name','id');
      // useful data 
      $usefuls_data = DB::table('useful_data')->Where('useful_description_id',$id)->get();
      return view('Admin.useful_information.useful_listing.form')
                                      ->with('UsefulInfoListings',$UsefulInfoListings)
                                      ->with('useful_info_category',$useful_info_category)
                                      ->with('usefuls_data',$usefuls_data)
                                      ->with('view_title',$this->view_title)
                                      ->with('action',"Edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsefulInfoListingRequest $request, $id)
    {

      $input = $request->all();
      $date_create = date('d-M-Y/');
      $attributes_data = '';
      $query_del = DB::table('useful_data')->where('useful_description_id',$id)->delete();

      // if($input['attribute_data']==''){
      //   dd("no att data!");
      // }
      // dd($input['year']);
      if(isset($input['attribute_data'])){
        $attributes_data = $input['attribute_data'];
        foreach ($attributes_data as $attribute_data) {
          if($attribute_data['attach_file']!=''){
            // dd("here");
            $file_attachs = $attribute_data['attach_file'];
            $destinationPath_data = 'images/upload/useful_information/attach_file/'.$date_create; 
            $extension = $file_attachs->getClientOriginalExtension(); 
            $file_attach_name_data = $file_attachs->getClientOriginalName();
            $file_data = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name_data);
            $file_attachs->move($destinationPath_data, $file_data);

            $file_name = $date_create.$file_data;

          }else{
            // dd("no");
            $file_name = $attribute_data['attach_file_hidden'];
          }
          
          DB::table('useful_data')
            ->insert(
            [
              'useful_description_id' => $id,
              'name' => $attribute_data['name'],
              'attach_file' => $file_name,
            ]
          );
        }
      }

      // dd($attribute_data);
      $pathToFile='';
      // checking file is valid.
      $size = (str_replace('MB','',MAX_FILE_SIZE))*1024;
      if (Input::file('attach_file')!='') {
         
        $rules = array(
          'name' => 'Required',
          'attach_file' => 'max:'.$size 
        );

        $messages = [
           'name.required' => 'Provide your name!',
           'attach_file.max' =>'Max attachment file size is '.MAX_FILE_SIZE.'!',      
        ];

        $v = Validator::make($input, $rules, $messages);
        if( $v->passes() ) {
          $file_attach = $request->get('attach_file');
         
          $destinationPath = 'images/upload/useful_information/attach_file/'.$date_create; // upload path
          $extension = Input::file('attach_file')->getClientOriginalExtension(); // getting image extension
          //$fileName = rand(11111,99999).'.'.$extension; // renameing image
          $file_attach_name = Input::file('attach_file')->getClientOriginalName();
          // $file = preg_replace('/\s+/', '_', $file_attach_name);
          $file = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_attach_name);
          // dd($file_attach_name);
          Input::file('attach_file')->move($destinationPath, $file);
          $pathToFile = SITE_HTTP_URL.'images/upload/useful_information/attach_file/'.$date_create.$file;

          DB::table('useful_description')
              ->where('id', $id)
              ->update(
                  [
                  'name' => $input['name'],
                  'year' => $input['year'],
                  'modified_by' => Auth::user()->id,
                  'useful_InfoCategory_id' => $input['useful_InfoCategory_id'],
                  'url' => $input['url'],
                  'attach_file' => $date_create.$file,
                  'description' => $input['description']
                  ]
              );
        }else{
          return redirect()->back()->withErrors($v->errors());
        }
      }else{
        DB::table('useful_description')
                ->where('id', $id)
                ->update(
                    [
                    'name' => $input['name'],
                    'year' => $input['year'],
                    'modified_by' => Auth::user()->id,
                    'useful_InfoCategory_id' => $input['useful_InfoCategory_id'],
                    'url' => $input['url'],
                    'description' => $input['description']
                    ]
                );
      }
      
      return redirect("admin/useful_information/useful_listing")->with('message',"Useful Information => (".$request['name'].") has been modified.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      UsefulInfoListing::find($id)->delete();
      $query_del = DB::table('useful_data')->where('useful_description_id',$id)->delete();
      return redirect()->back()->with('message','Deleted Successfully');
    }

}
