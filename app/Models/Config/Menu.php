<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
	protected $table = 'menu';
	protected $guarded  = [];
	public $timestamps = false;
	
	/* public function origin_office(){
		return $this->belongsTo('App\Models\Admin\OriginOffice','base_id');
	} */
	
}
