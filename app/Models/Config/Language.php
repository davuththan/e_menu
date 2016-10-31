<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
	protected $table = 'language';
	protected $guarded  = [];
	//public $timestamps = false;
	
	/* public function origin_office(){
		return $this->belongsTo('App\Models\Admin\OriginOffice','base_id');
	} */
	public function rules(\Illuminate\Http\Request $request){
		return [
				'report_to'=>'required',
				//'title'=>'required',
				//'author'=>'required',
		];
	}
}
