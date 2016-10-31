<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsDes extends Model
{
    //
	protected $table = 'news_description';
	protected $guarded  = [];
	public $timestamps = false;
	
	// public function new(){
	// 	return $this->belongsTo('App\Models\News','news_id');
	// }
	public function rules(\Illuminate\Http\Request $request){
		$ruleset = [
				'name'=>'required|array',
				'description'=>'required|array',
		];
		
		return $ruleset;
	}
}
