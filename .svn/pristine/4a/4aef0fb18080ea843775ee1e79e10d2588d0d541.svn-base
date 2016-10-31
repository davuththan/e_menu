<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    //
	protected $table = 'project_category';
	protected $guarded  = [];
	
	//protected $fillable =['id','name'];
	//public $timestamps = false;
	
	public function project_category_des(){
		return $this->hasMany('App\Models\ProjectCateogryDes','project_category_id');
	}
}
