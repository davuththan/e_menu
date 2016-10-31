<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
	protected $table = 'user';
	protected $fillable = ['username', 
						    'password',
							'photo',
							'group_id',
							'email'
							
	];
	 
	public $timestamps = false;
	
	
	public function GroupUser(){
		return $this->belongsTo('App\Models\Admin\GroupUser','group_id');
	}
}
