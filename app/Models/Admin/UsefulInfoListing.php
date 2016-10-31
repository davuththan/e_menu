<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UsefulInfoListing extends Model
{
	protected $table = 'useful_description';
	protected $fillable = ['useful_InfoCategory_id','name','image','url','attach_file','description','modified_by','year'];
 
	public $timestamps = true;

	public function UsefulInfoCategory(){
		return $this->belongsTo('App\Models\Admin\UsefulInfoCategory','useful_InfoCategory_id');
	}
	
}
