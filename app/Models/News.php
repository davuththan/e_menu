<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
	protected $table = 'news';
	protected $guarded  = [];
	
	//protected $fillable =['id','name'];
	//public $timestamps = false;
	
	public function news_des(){
		return $this->hasMany('App\Models\NewsDes','news_id');
	}
}
