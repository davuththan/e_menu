<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
	protected $table = 'partner';
	protected $fillable = ['name','image','order_level','url','description','modified_by'];
	public $timestamps = true;
	
}
