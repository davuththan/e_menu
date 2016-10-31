<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDes extends Model
{
    //
    protected $table = 'project_description';
	protected $guarded  = [];
	public $timestamps = false;
	public function rules(\Illuminate\Http\Request $request){
		$ruleset = [
				'name'=>'required|array',
				'description'=>'required|array',
		];
		
		return $ruleset;
	}
}
