<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
	protected $table = 'category';
	protected $guarded  = [];
	//public $timestamps = false;
	
	public function category_des(){
		return $this->hasMany('App\Models\CategoryDes','category_id');
	}
	
}
