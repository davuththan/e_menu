<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class FMenuDescription extends Model {

	protected $table = 'fmenu_description';
	
	protected $fillable = ['name','description','fmenu_id','language_id','meta_keywords','meta_description'];

	public $timestamps = false;
	
	
	public function getFMenuDescription($fmenu_id,$language_id=2){
		return $this->belongsTo('App\Models\Admin\FMenuModel','fmenu_id');
	}
	
}
