<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
	protected $table = 'committee';
	protected $fillable = ['name','image','position','company','contact','email','order_level','modified_by'];
	public $timestamps = true;
	
}
