<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model {

	protected $table = 'menu_type';
	
	protected $fillable = ['name'];

	public $timestamps = false;
	
	
	public function fmenu(){
		return $this->belongsTo('App\Models\Admin\FMenuModel','menu_type_id');
	}
	
}
