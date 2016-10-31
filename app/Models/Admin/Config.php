<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $table = 'config';
	protected $fillable = ['config_group_id', 
						    'name',
							'keywords',
							'value'							
	];
	
	public $timestamps = false;
	public function config_group(){
		return $this->belongsTo('App\Models\Admin\ConfigGroup','config_group_id','id');
		 //return $this->hasMany('App\ConfigGroup');
	}
}
