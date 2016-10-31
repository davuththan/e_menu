<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	protected $table = 'banner';
	protected $fillable = ['name','image','is_active','url','description','modified_by'];
	public $timestamps = true;
	
}
