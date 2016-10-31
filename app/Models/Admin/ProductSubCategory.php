<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
	protected $table = 'product_sub_category';
	protected $fillable = ['pc_id','icon','name_en','order_level','name_kh','created_by','updated_by'];
 
	public $timestamps = true;

	public function ProductCategory(){
		return $this->belongsTo('App\Models\Admin\ProductCategory','pc_id');
	}
	
}
