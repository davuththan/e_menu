<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class FMenuModel extends Model
{
	protected $table = 'fmenu';
	protected $fillable = [
							'fa_icon', 
							'parent_id', 
						    'menu_type_id',
							'menu_link',
							'url',
							'attach_file',
						    'ordering',
						    'is_active',
						    'modified_by',
							
	];
	
	public $timestamps = true;
	
	public function FMenuType(){
		return $this->belongsTo('App\Models\Admin\MenuType','menu_type_id');
	}
	public function FmenuDescription(){
		//return $this->belongsTo('App\Models\Admin\FMenuDescription','fmenu_id');
	}
}
