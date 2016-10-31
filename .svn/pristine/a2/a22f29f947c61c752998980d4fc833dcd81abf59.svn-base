<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerDes extends Model
{
    //
	protected $table = 'career_description';
	protected $guarded  = [];
	public $timestamps = false;
	
	public function career(){
		return $this->belongsTo('App\Models\Career','career_id');
	}
	public function rules(\Illuminate\Http\Request $request){
		/* return [
				'report_to'=>'required',
				//'job_title'=>'required|array',
				//'author'=>'required',
		]; */
		$ruleset = [
				'job_title'=>'required|array',
		];
		
		return $ruleset;
	}
}
