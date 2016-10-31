<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
	protected $table = 'project';
	protected $guarded  = [];
	
	//protected $fillable =['id','name'];
	//public $timestamps = false;
	
	public function project_des(){
		return $this->hasMany('App\Models\ProjectDes','project_id');
	}
}
