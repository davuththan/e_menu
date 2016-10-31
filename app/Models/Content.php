<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    //
	protected $table = 'content';
	protected $guarded  = [];
	//public $timestamps = false;
	
	public function content_des(){
		return $this->hasMany('App\Models\ContentDes','content_id');
	}
}
