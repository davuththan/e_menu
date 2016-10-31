<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	protected $table = 'position';
	protected $fillable = ['name','modified_by'];
 
	public $timestamps = true;
	
}
