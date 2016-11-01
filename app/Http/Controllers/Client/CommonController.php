<?php

namespace App\Http\Controllers\Client;
use App;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSubCategory;
use DB;
use Illuminate\Http\Request;
use Session;

class CommonController extends Controller {
	public function __construct() {
		date_default_timezone_set('Asia/Phnom_Penh');
		$languages = DB::table('language')->get();
		$language_id = Session::get('applangId');
		if ($language_id == 1) {
			App::setLocale('kh');
		} else if ($language_id == 2) {
			App::setLocale('en');
		} else if ($language_id == 3) {
			App::setLocale('ch(simplify)');
		} else if ($language_id == 4) {
			App::setLocale('ch(traditional)');
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index() {

		if (Session::get('applangId')) {
			$language_id = Session::get('applangId');
		} else {
			$language_id = CONFIG_LANGUAGE;
		}

		$products = Product::get();
		$product_arr = array();
		foreach ($products as $product) {
			$product_id = $product->id;
			$product_images = DB::table("product_image")->Where('pc_id', $product_id)->get();
			$product_image_arr = array();
			foreach ($product_images as $product_image) {
				$product_image_arr[] = array(
					'pc_id' => $product_image->pc_id,
					'image' => $product_image->image,
					'title_en' => $product_image->title_en,
					'title_kh' => $product_image->title_kh,
					'order_level' => $product_image->order_level,
				);
			}

			$product_arr[] = array(
				'id' => $product->id,
				'pc_id' => $product->pc_id,
				'spc_id' => $product->spc_id,
				'icon' => $product->icon,
				'photo' => $product->photo,
				'name_en' => $product->name_en,
				'name_kh' => $product->name_kh,
				'price' => $product->price,
				'description' => $product->description,
				'product_image_arr' => $product_image_arr,
			);

		}

		$product_categories = ProductCategory::orderBy('order_level', 'asc')->get();
		$product_sub_categories = ProductSubCategory::Where('pc_id', 1)->get();
		return view('Client.home')->with('product_arr', $product_arr)
			->with('product_sub_categories', $product_sub_categories)
			->with('product_categories', $product_categories);
	}

	public function getPCCategory(Request $request) {
		$data = $request->all();

		$pc_id = $data['pc_id'];

		$results = DB::table("product_sub_category")->Where('pc_id', $pc_id)->get();
		$data_arr = array();
		foreach ($results as $result) {
			$data_arr[] = array(
				'psc_id' => $result->id,
				'psc_name_en' => $result->name_en,
				'psc_name_kh' => $result->name_kh,
			);
		}

		$result_products = DB::table("product")->Where('pc_id', $pc_id)->LIMIT(6)->get();

		$data_product_arr = array();
		foreach ($result_products as $result_product) {
			$data_product_arr[] = array(
				'id' => $result_product->id,
				'photo' => $result_product->photo,
				'price' => $result_product->price,
				'name_en' => $result_product->name_en,
				'name_kh' => $result_product->name_kh,
			);
		}

		$data_whole_arr[] = array(
			'sub_cat_product' => $data_arr,
			'product' => $data_product_arr,
		);
		return json_encode($data_whole_arr);
	}

	public function getSPCCategory(Request $request) {
		$data = $request->all();

		$spc_id = $data['spc_id'];

		$results = DB::table("product")->Where('spc_id', $spc_id)->Limit(6)->get();
		$data_arr = array();
		foreach ($results as $result) {
			$data_arr[] = array(
				'id' => $result->id,
				'photo' => $result->photo,
				'price' => $result->price,
				'name_en' => $result->name_en,
				'name_kh' => $result->name_kh,
				'description' => $result->description,
			);
		}

		return json_encode($data_arr);
	}

	public function getSubCategoryDetail(Request $request) {
		$data = $request->all();

		$pc_id = $data['pc_id'];

		$results = DB::table("product_image")->Where('pc_id', $pc_id)->OrderBy('order_level')->get();
		$data_arr = array();
		foreach ($results as $result) {
			$data_arr[] = array(
				'image' => $result->image,
				'title_en' => $result->title_en,
				'title_kh' => $result->title_kh,
			);
		}

		return json_encode($data_arr);
	}

}
