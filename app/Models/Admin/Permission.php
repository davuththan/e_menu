<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    
    protected $table = 'role';
	protected $fillable = ['name', 'permission','display_name'];

}