<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSubCategory;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class ProductController extends Controller
{
	
	public $view_title = "Products";
	

    public function __construct()
    {

    }

    
    public function index()
    {
      $products = Product::OrderBy('id','DESC')->get();
      return view('Admin.category.product.index')
             ->with('products',$products)
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
        $product_sub_category = ProductSubCategory::lists('name_en','id');
        return view('Admin.category.product.form')
        								->with('view_title',$this->view_title)
                                        ->with('product_category',$product_category)
                                        ->with('product_sub_category',$product_sub_category)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductRequest $request)
    {
      $input = $request->all();
      // dd($input);
      $date_create = date('d-M-Y/');
      // dd($input);
      $fileName_data = "";
      if (Input::file('photo')!="") {
         $image = $input['photo'];
         $destinationPath = 'images/upload/product/'.$date_create; // upload path
         $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileName = $image->getClientOriginalName();
         Input::file('photo')->move($destinationPath, $fileName); // uploading file to 
         $fileName_data = $date_create.$fileName;
         // $input["photo"] = $fileName;
      }

      // dd($input);
      $fileIconName_data = "";
      if (Input::file('icon')!="") {
         $image_icon = $input['icon'];
         $destinationPath = 'images/upload/icon/'.$date_create; // upload path
         $extension = Input::file('icon')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileIconName = $image_icon->getClientOriginalName();
         Input::file('icon')->move($destinationPath, $fileIconName); // uploading file to
         $fileIconName_data = $date_create.$fileIconName;
      }

      // UserModel::create($input);
      // Product::create([
      //   'pc_id' => Input::get('pc_id'),
      //   'spc_id' => Input::get('spc_id'),
      //   'icon' => $fileIconName_data,
      //   'photo' => $fileName_data,
      //   'name_en' => Input::get('name_en'),
      //   'name_kh' => Input::get('name_kh'),
      //   'price' => Input::get('price'),
      //   'description' => Input::get('description'),
      //   'created_at' => date('Y-m-d H:i:s'),
      //   'created_by' => Auth::user()->id,
      // ]);

      $lastId = Product::insertGetId(
          [
            'pc_id' => Input::get('pc_id'),
            'spc_id' => Input::get('spc_id'),
            'icon' => $fileIconName_data,
            'photo' => $fileName_data,
            'name_en' => Input::get('name_en'),
            'name_kh' => Input::get('name_kh'),
            'price' => Input::get('price'),
            'description' => Input::get('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
          ]
        );

      if(isset($input['attribute_image'])){
         $attribute_images = $input['attribute_image'];
         foreach ($attribute_images as $attribute_image) {
            DB::table("product_image")->Insert([
              'pc_id' => $lastId,
              'image' => $attribute_image['image'],
              'title_en' => $attribute_image['title_en'],
              'title_kh' => $attribute_image['title_kh'],
              'order_level' => $attribute_image['order_level']
            ]);
         }
      }


      //##########Set Event for ActivityLog############

      // Product::create($request->all());
      return redirect("admin/category/product")->with('message',"product => (".$request['name_en'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_category = ProductCategory::lists('name','id');
        $product_sub_category = ProductSubCategory::lists('name_en','id');
        $product = Product::find($id);
        return view('Admin.category.product.form')->with('product',$product)
                                        ->with('view_title',$this->view_title)
                                        ->with('product_sub_category',$product_sub_category)
                                        ->with('product_category',$product_category)
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
        $product_sub_category = ProductSubCategory::lists('name_en','id');
        $attribute_images = DB::table("product_image")->Where('pc_id',$id)->get();
        $product = Product::find($id);
        return view('Admin.category.product.form')->with('product',$product)
                                        ->with('product_category',$product_category)
                                        ->with('attribute_images',$attribute_images)
                                        ->with('product_sub_category',$product_sub_category)
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
    public function update(ProductRequest $request, $id)
    {
      $input = $request->all();
      $date_create = date('d-M-Y/');
      // dd($input);
      $fileName_data = "";
      if (Input::file('photo')!='') {
         $image = $input['photo'];
         $destinationPath = 'images/upload/product/'.$date_create; // upload path
         $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileName = $image->getClientOriginalName();
         Input::file('photo')->move($destinationPath, $fileName); // uploading file to 
         // $input["photo"] = $fileName;
         $fileName_data = $date_create.$fileName;
      }else{
         $fileName_data = $input["photo_hidden"];
      }

      // dd($input);
      $fileIconName_data = "";
      if (Input::file('icon')!="") {
         $image = $input['icon'];
         $destinationPath = 'images/upload/icon/'.$date_create; // upload path
         $extension = Input::file('icon')->getClientOriginalExtension(); // getting image extension
         //$fileName = rand(11111,99999).'.'.$extension; // renameing image
         $fileIconName = $image->getClientOriginalName();
         Input::file('icon')->move($destinationPath, $fileIconName); // uploading file to 
         // $input["photo"] = $fileName;
         $fileIconName_data = $date_create.$fileIconName;
      }else{
         $fileIconName_data = $input["icon_hidden"];
      }

      $product = Product::find($id);
      $product->update(
         [
         // $request->all()
         'pc_id' => $input['pc_id'],
         'spc_id' => $input['spc_id'],
         'icon' => $fileIconName_data,
         'photo' => $fileName_data,
         'name_en' => $input['name_en'],
         'name_kh' => $input['name_kh'],
         'price' => $input['price'],
         'description' => $input['description'],
         'updated_at' => date('Y-m-d H:i:s'),
         'updated_by' => Auth::user()->id,
         ]
      );

      if(isset($input['attribute_image'])){
         DB::table("product_image")->Where("pc_id",$id)->delete();
         $attribute_images = $input['attribute_image'];
         foreach ($attribute_images as $attribute_image) {

            if(isset($attribute_image['image'])){
               $destinationPath = 'images/upload/product/'.$date_create;
                $filename_image_alt = $attribute_image['image']->getClientOriginalName();
                $filename_image = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename_image_alt);
                $attribute_image['image']->move($destinationPath, $filename_image);

               $img_arr = [
                          'pc_id' => $id,
                          'image' => $date_create.$filename_image,
                          'title_en' => $attribute_image['title_en'],
                          'title_kh' => $attribute_image['title_kh'],
                          'order_level' => $attribute_image['order_level']
                          ];
            }else{
               $img_arr = [
                          'pc_id' => $id,
                          'image' => $attribute_image['image_hidden'],
                          'title_en' => $attribute_image['title_en'],
                          'title_kh' => $attribute_image['title_kh'],
                          'order_level' => $attribute_image['order_level']
                          ];
            }
            DB::table("product_image")->Insert($img_arr);
         }
      }

      return redirect("admin/category/product")->with('message',"product => (".$request['name_en'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
