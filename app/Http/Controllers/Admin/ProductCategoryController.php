<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\ProductCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class ProductCategoryController extends Controller
{
	
	public $view_title = "Product Category";
	

    public function __construct()
    {

    }

    
    public function index()
    {
        $product_categories = ProductCategory::all();
        return view('Admin.category.product_category.index')
                ->with('product_categories',$product_categories)
                ->with('view_title',$this->view_title);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.category.product_category.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductCategoryRequest $request)
    {
        $date_create = date('d-M-Y/');
        $input = $request->all();
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

        ProductCategory::create(
          [
            'icon' => $fileName_data,
            'name' => $input['name'],
            'order_level' => $input['order_level'],
            'created_at' => $this->DateNow(),
            'created_by' => Auth::user()->id,
          ]
        );

        // ProductCategory::create($request->all());
        return redirect("admin/category/product_category")
                ->with('message',"Product Category => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_category = ProductCategory::find($id);
        return view('Admin.category.product_category.form')->with('product_category',$product_category)
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
        $product_category = ProductCategory::find($id);
        return view('Admin.category.product_category.form')->with('product_category',$product_category)
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
    public function update(ProductCategoryRequest $request, $id)
    {
        $input = $request->all();
        $date_create = date('d-M-Y/');
       $ProductCategory = ProductCategory::find($id);
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

      $ProductCategory->update(
         [
            'icon' => $fileName_data,
            'name' => $input['name'],
            'order_level' => $input['order_level'],
            'created_at' => $this->DateNow(),
            'created_by' => Auth::user()->id,
         ]
      );

       return redirect("admin/category/product_category")->with('message',"Product Category => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductCategory::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
