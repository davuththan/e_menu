<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductSubCategoryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\ProductSubCategory;
use App\Models\Admin\ProductCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class ProductSubCategoryController extends Controller
{
	
	public $view_title = "Product Category";
	

    // public function __construct()
    // {

    // }

    
    public function index()
    {
        $product_sub_categories = ProductSubCategory::all();
        return view('Admin.category.product_sub_category.index')
                ->with('product_sub_categories',$product_sub_categories)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::lists('name','id');
        return view('Admin.category.product_sub_category.form')
        								->with('view_title',$this->view_title)
                                        ->with('product_category',$product_category)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductSubCategoryRequest $request)
    {   
        $date_create = date('d-M-Y/');
        $input = $request->all();
        // ProductSubCategory::create($request->all());
        // dd($input);
        $fileName_data = "";
        if (Input::file('icon')!="") {
         $image = $input['icon'];
         $destinationPath = 'images/upload/icon/'.$date_create; // upload path
         $extension = Input::file('icon')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileName = $image->getClientOriginalName();
         Input::file('icon')->move($destinationPath, $fileName); // uploading file to 
         $fileName_data = $date_create.$fileName;
         // $input["photo"] = $fileName;
        }

        ProductSubCategory::create(
          [
            'pc_id' => $input['pc_id'],
            'icon' => $fileName_data,
            'name_en' => $input['name_en'],
            'name_kh' => $input['name_kh'],
            'order_level' => $input['order_level'],
            'created_at' => $this->DateNow(),
            'created_by' => Auth::user()->id,
          ]
        );

        return redirect("admin/category/product_sub_category")
                                    ->with('message',"Product Category => (".$request['name_en'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_sub_category = ProductSubCategory::find($id);
        $product_category = ProductCategory::lists('name','id');
        return view('Admin.category.product_sub_category.form')
                                        ->with('product_sub_category',$product_sub_category)
                                        ->with('product_category',$product_category)
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
        $product_category = ProductCategory::lists('name','id');
        $product_sub_category = ProductSubCategory::find($id);
        return view('Admin.category.product_sub_category.form')->with('product_sub_category',$product_sub_category)
                                        ->with('product_category',$product_category)
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
    public function update(ProductSubCategoryRequest $request, $id)
    {

        $date_create = date('d-M-Y/');
        $input = $request->all();
        $ProductSubCategory = ProductSubCategory::find($id);

        // $ProductSubCategory->update($request->all());
        // $ProductCategory = ProductCategory::find($id);
        // $ProductCategory->update($request->all());

        // dd($input);
        $fileName_data = "";
        if (Input::file('icon')!="") {
         $image = $input['icon'];
         $destinationPath = 'images/upload/icon/'.$date_create; // upload path
         $extension = Input::file('icon')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileName = $image->getClientOriginalName();
         Input::file('icon')->move($destinationPath, $fileName); // uploading file to 
         // $input["icon"] = $fileName;
         $fileName_data = $date_create.$fileName;
        }else{
         $fileName_data = $input["icon_hidden"];
        }

        $ProductSubCategory->update(
          [
            'pc_id' => $input['pc_id'],
            'icon' => $fileName_data,
            'name_en' => $input['name_en'],
            'name_kh' => $input['name_kh'],
            'order_level' => $input['order_level'],
            'created_at' => $this->DateNow(),
            'updated_by' => Auth::user()->id,
          ]
        );

       return redirect("admin/category/product_sub_category")->with('message',"Product Category => (".$request['name_en'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductSubCategory::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
