<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GroupRoleDetail extends Model {

	protected $table = 'group_role_detail';
	
	protected $fillable = ['group_role_id',
							'menu_code',
							'parent_menu_id',
							'menu_id',
							'read',
							'write'
							];

	public $timestamps = false;
	
	
	public function group_user(){
		return $this->belongsTo('App\Models\Admin\GroupUser','group_id');
	}

}
