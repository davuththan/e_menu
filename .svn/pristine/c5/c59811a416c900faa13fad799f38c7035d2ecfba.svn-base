<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
	protected $table = 'user';
	protected $guarded  = [];
	
	public function rules(\Illuminate\Http\Request $request){
		return [
				'username' => 'required',
        		'password' => 'required|confirmed|min:6',
        		'email' => 'email|max:255|unique:user',
        		'group_id' => 'required'
		];
	}
}
