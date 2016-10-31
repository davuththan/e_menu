<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    //
	protected $table = 'career';
	protected $guarded  = [];
	
	//protected $fillable =['id','name'];
	//public $timestamps = false;
	
	public function career_des(){
		return $this->hasMany('App\Models\CareerDes','career_id');
	}
	
}
