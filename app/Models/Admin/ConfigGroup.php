<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigGroup extends Model
{
	protected $table = 'config_group';
	protected $fillable = ['name'];
	
	public $timestamps = false;//to avoid updated_at and created_at in default laravel framwork
}
