<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/*protected $table = 'role'
	protected $fillable = ['title', 'order_level'];
    protected $hidden = ['password', 'remember_token'];*/
    protected $table = 'role';
    public function users()
    {
        return $this->hasMany('App\UserModel', 'role_id', 'id');
    }
}
