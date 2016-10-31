<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
    protected $table = 'slide';
    protected $guarded  = [];
	public $timestamps = false;

	public function slide_des(){
		return $this->hasMany('App\Models\SlideDes','slide_id');
	}
}

