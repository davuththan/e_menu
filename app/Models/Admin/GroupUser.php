<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model {

	protected $table = 'group_user';
	
	protected $fillable = ['name',
							'status',
							'remark'
							];

	public $timestamps = false;

	
}
