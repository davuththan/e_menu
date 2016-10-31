<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'product';
	protected $fillable = ['pc_id','spc_id','icon','photo','name_en','name_kh','price','description','created_by','updated_by'];
 
	public $timestamps = true;

	public function ProductCategory(){
		return $this->belongsTo('App\Models\Admin\ProductCategory','pc_id');
	}

	public function ProductSubCategory(){
		return $this->belongsTo('App\Models\Admin\ProductSubCategory','spc_id');
	}
	
}
